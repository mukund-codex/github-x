<?php

return [
    'bucket' => env('AWS_BUCKET'),

    'access_key' => env('AWS_ACCESS_KEY_ID'),

    'secret_key' => env('AWS_SECRET_ACCESS_KEY'),

    'region' => env('AWS_REGION', 'eu-west-2'),

    'expiry_time' => env('AWS_EXPIRY_IN_MINUTES', 10),
];
