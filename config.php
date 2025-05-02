<?php

return [
    'google' => [
        'client_id'     => '789283966110-ias9be9l181b1tct3efbmeieahev4v97.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect_uri'      => 'http://localhost:8888/callback',
    ],
    'database' => [
        'host' => 'localhost', // 192.168.71.194
        'port' => 3306, // port: 3206
        'dbname' => 'hr_ram', //3206_DB
        'charset' => 'utf8mb4',
    ],
    'usm' => [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'sub_user_management',
        'charset' => 'utf8mb4',
    ],
];
