<?php

declare(strict_types=1);

return [
    'driver' => env('MESSAGING_DRIVER', 'rabbitmq'),

    'rabbitmq' => [
        'host' => env('RABBITMQ_HOST', '127.0.0.1'),
        'port' => env('RABBITMQ_PORT', 5672),
        'user' => env('RABBITMQ_USER', 'guest'),
        'password' => env('RABBITMQ_PASSWORD', 'guest'),
    ],

    'kafka' => [
        'brokers' => env('KAFKA_BROKERS', '127.0.0.1:9092'),
    ],

    'sqs' => [
        'region' => env('AWS_REGION', 'us-east-1'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
];
