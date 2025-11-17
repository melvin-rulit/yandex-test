<?php

return [
    'default' => env('BROADCAST_DRIVER', 'reverb'),

    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => env('PUSHER_USETLS', false),
                'host' => env('PUSHER_HOST'),
                'port' => env('PUSHER_PORT'),
                'scheme' => env('PUSHER_SCHEME', 'http'),
                'wsHost' => env('PUSHER_WS_HOST', env('PUSHER_HOST')),
                'wsPort' => env('PUSHER_WS_PORT', env('PUSHER_PORT')),
                'wssPort' => env('PUSHER_WSS_PORT', env('PUSHER_PORT')),
                'forceTLS' => env('PUSHER_FORCE_TLS', false),
                'enabledTransports' => ['ws', 'wss'],
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],
    ],
];


