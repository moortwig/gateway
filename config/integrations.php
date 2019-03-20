<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Integrations
    |--------------------------------------------------------------------------
    |
    | This file is for storing routes and configurations regarding external APIs.
    |
    */

    'test' => [
        'base_url' => 'http://dummy.restapiexample.com/api',
        'version' => 'v1',
        'format' => '%s/%s/%s',
    ],

    'reward_gateway' => [
        'base_url' => 'http://hiring.rewardgateway.net',
        'format' => '%s/%s',
        'auth' => [
            'username' => env('RG_USERNAME'),
            'password' => env('RG_PASSWORD'),
        ],
        'param' => [
            'authorization' => env('RG_AUTHORIZATION'),
        ]
    ],
];