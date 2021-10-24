<?php

return [
    # Define your application mode here
    'mode' => env('PAYPAL_MODE', 'sandbox'), // live

    'currency' => env('CURRENCY', 'USD'),

    # Account credentials from developer portal
    'account' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
    ],

    # Connection Information
    'http' => [
        'connection_time_out' => 60,
        'retry' => 2,
    ],

    # Logging Information
    'log' => [
        'log_enabled' => true,

        # When using a relative path, the log file is created
        # relative to the .php file that is the entry point
        # for this request. You can also provide an absolute
        # path here
        'file_name' => storage_path('/logs/paypal.log'),

        # Logging level can be one of FINE, INFO, WARN or ERROR
        # Logging is most verbose in the 'FINE' level and
        # decreases as you proceed towards ERROR
        'log_level' => 'ERROR', // FINE
    ],
];
