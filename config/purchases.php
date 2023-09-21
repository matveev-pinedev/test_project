<?php

return [
    'stripe_price_ids' => [
        'b2b' => env('STRIPE_PRICE_B2B'),
        'b2c' => env('STRIPE_PRICE_B2C'),
    ],
];
