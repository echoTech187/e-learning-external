<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// =====================================================
// WEBHOOK ROUTES (EXTERNAL API)
// =====================================================
$routes->group('webhooks', ['namespace' => 'App\Controllers\Webhooks'], static function ($routes) {
    // Nanti akan diisi route untuk Midtrans, Zoom, dll.
});


// =====================================================
// CRON JOB ROUTES (INTERNAL SCHEDULED TASKS)
// =====================================================
// Protected by Bearer token (CRON_SECRET_KEY in .env).
// Trigger via: curl -H "Authorization: Bearer <key>" http://external/cron/order-expiry
$routes->group('cron', ['namespace' => 'App\Controllers\Cron'], static function ($routes) {
    // Expire pending orders older than 1 hour
    $routes->get('order-expiry', 'OrderExpiry::run');
});
