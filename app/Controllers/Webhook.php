<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * Webhook Controller
 * 
 * Handles incoming webhooks from third-party services (like Midtrans)
 * and proxies them to the internal service for processing.
 */
class Webhook extends BaseController
{
    public function midtrans()
    {
        $jsonPayload = $this->request->getBody();
        
        // Forward the exact payload to the internal service
        $internalUrl = getenv('INTERNAL_SERVICE_URL') ?: 'http://internal';
        
        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->post($internalUrl . '/api/v1/transactions/webhook', [
                'body' => $jsonPayload,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json'
                ]
            ]);
            
            // Just return whatever the internal service returns
            return $this->response
                ->setStatusCode($response->getStatusCode())
                ->setJSON(json_decode($response->getBody()));
                
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Webhook Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to forward webhook'
            ]);
        }
    }
}