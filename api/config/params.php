<?php

return [
    'adminEmail' => 'info@rn500.com',
    'logPath' => "@app/runtime/logs",
    'jwtTokenInfo' => [
        "key" => "8439ae35149b1a49454ea703f148330aae0ad457c98608a535b33b4bbf53abe6"
    ],
    'disableAuth' => [
        'login', 'registration', 'forgotpassword', 'get-user-ip', 'register', 'get-count', 'checkemail', 'resend-otp'
    ],
    'maintenance_mode' => 'OFF',
    'session_expire' => '+48 hours',
];
