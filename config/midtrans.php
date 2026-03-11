<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    
    // URL untuk callback/notification
    'notification_url' => env('APP_URL') . '/midtrans/webhook',
    'finish_url' => env('APP_URL') . '/payment/finish',
];
