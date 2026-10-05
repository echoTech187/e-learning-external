<?php

namespace App\Controllers\Cron;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

/**
 * Cron\OrderExpiry
 *
 * Scheduled job controller that expires pending orders older than 1 hour.
 * This controller lives in e-learning-external and calls the internal service
 * via HTTP, keeping business logic strictly separated (Zero Assumption architecture).
 *
 * Endpoint : GET /cron/order-expiry
 * Security  : Bearer token via CRON_SECRET_KEY in .env
 *
 * How to schedule (Linux/Production):
 *   # crontab -e
 *   *\/5 * * * * curl -s -H "Authorization: Bearer <CRON_SECRET_KEY>" http://external/cron/order-expiry >> /var/log/cron-expire.log 2>&1
 *
 * How to schedule (Windows Task Scheduler / local dev):
 *   Action: curl -s -H "Authorization: Bearer edunusa-cron-s3cr3t-k3y-2026" http://localhost/cron/order-expiry
 *   Trigger: Every 5 minutes
 */
class OrderExpiry extends Controller
{
    use ResponseTrait;

    /**
     * Main cron handler.
     * Validates the secret key, calls the internal auto-expire endpoint,
     * and logs the result.
     */
    public function run()
    {
        // -------------------------------------------------------
        // 1. AUTH: Validate secret key from Authorization header
        // -------------------------------------------------------
        $cronSecret = getenv('CRON_SECRET_KEY') ?: 'edunusa-cron-s3cr3t-k3y-2026';
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token      = trim(str_replace('Bearer', '', $authHeader));

        if (empty($token) || $token !== $cronSecret) {
            return $this->failUnauthorized('Invalid or missing cron secret key.');
        }

        // -------------------------------------------------------
        // 2. CALL internal service auto-expire endpoint
        // -------------------------------------------------------
        $internalUrl = rtrim(getenv('INTERNAL_SERVICE_URL') ?: 'http://internal', '/');

        $client = \Config\Services::curlrequest(['http_errors' => false]);

        try {
            $response = $client->post("{$internalUrl}/api/transactions/auto-expire", [
                'headers' => ['Accept' => 'application/json'],
                'timeout' => 30,
            ]);

            $statusCode = $response->getStatusCode();
            $body       = json_decode($response->getBody(), true);

            $expiredCount = $body['expired_count'] ?? 0;
            $message      = $body['message'] ?? 'No message returned';

            // -------------------------------------------------------
            // 3. LOG the result
            // -------------------------------------------------------
            $logEntry = sprintf(
                "[%s] [CRON:OrderExpiry] Status=%d | Expired=%d | Msg=%s\n",
                date('Y-m-d H:i:s'),
                $statusCode,
                $expiredCount,
                $message
            );
            $logPath = WRITEPATH . 'logs/cron-order-expiry.log';
            file_put_contents($logPath, $logEntry, FILE_APPEND | LOCK_EX);

            return $this->respond([
                'success'       => true,
                'executed_at'   => date('Y-m-d H:i:s'),
                'expired_count' => $expiredCount,
                'message'       => $message,
            ], $statusCode >= 200 && $statusCode < 300 ? 200 : 502);

        } catch (\Exception $e) {
            $logEntry = sprintf(
                "[%s] [CRON:OrderExpiry] ERROR: %s\n",
                date('Y-m-d H:i:s'),
                $e->getMessage()
            );
            $logPath = WRITEPATH . 'logs/cron-order-expiry.log';
            file_put_contents($logPath, $logEntry, FILE_APPEND | LOCK_EX);

            return $this->failServerError('Failed to reach internal service: ' . $e->getMessage());
        }
    }
}
