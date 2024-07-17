<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover"
    |
    */

    // 'mailers' => [
        // 'smtp' => [
        //     'transport' => 'smtp',
        //     'url' => env('MAIL_URL'),
        //     'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
        //     'port' => env('MAIL_PORT', 587),
        //     'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        //     'username' => env('MAIL_USERNAME'),
        //     'password' => env('MAIL_PASSWORD'),
        //     'timeout' => null,
        //     'local_domain' => env('MAIL_EHLO_DOMAIN'),
        // ],

        'mailers' => [
            'smtp' => [
                'transport' => 'smtp',
                'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
                'port' => env('MAIL_PORT', 587),
                'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'from' => [
                    'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                    'name' => env('MAIL_FROM_NAME', 'Example'),
                ],
            ],
    
            'smtp_bricon' => [
                'transport' => 'smtp',
                'host' => env('SECONDARY_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('SECONDARY_MAIL_PORT', 587),
                'encryption' => env('SECONDARY_MAIL_ENCRYPTION', 'tls'),
                'username' => env('SECONDARY_MAIL_USERNAME'),
                'password' => env('SECONDARY_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('SECONDARY_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('SECONDARY_MAIL_FROM_NAME', 'SecondaryExample'),
                ],
            ],


            'smtp_rig' => [
                'transport' => 'smtp',
                'host' => env('THIRD_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('THIRD_MAIL_PORT', 587),
                'encryption' => env('THIRD_MAIL_ENCRYPTION', 'tls'),
                'username' => env('THIRD_MAIL_USERNAME'),
                'password' => env('THIRD_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('THIRD_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('THIRD_MAIL_FROM_NAME', 'ThirdExample'),
                ],
            ],
            'smtp_lukemed' => [
                'transport' => 'smtp',
                'host' => env('FOURTH_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('FOURTH_MAIL_PORT', 587),
                'encryption' => env('FOURTH_MAIL_ENCRYPTION', 'tls'),
                'username' => env('FOURTH_MAIL_USERNAME'),
                'password' => env('FOURTH_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('FOURTH_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('FOURTH_MAIL_FROM_NAME', 'FourthExample'),
                ],
            ],

            'smtp_juscall' => [
                'transport' => 'smtp',
                'host' => env('FIFTH_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('FIFTH_MAIL_PORT', 587),
                'encryption' => env('FIFTH_MAIL_ENCRYPTION', 'tls'),
                'username' => env('FIFTH_MAIL_USERNAME'),
                'password' => env('FIFTH_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('FIFTH_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('FIFTH_MAIL_FROM_NAME', 'FifthExample'),
                ],
            ],

            'smtp_lukemedikal' => [
                'transport' => 'smtp',
                'host' => env('SIXTH_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('SIXTH_MAIL_PORT', 587),
                'encryption' => env('SIXTH_MAIL_ENCRYPTION', 'tls'),
                'username' => env('SIXTH_MAIL_USERNAME'),
                'password' => env('SIXTH_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('SIXTH_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('SIXTH_MAIL_FROM_NAME', 'SixthExample'),
                ],
            ],

            'smtp_lukeinternational' => [
                'transport' => 'smtp',
                'host' => env('SEVENTH_MAIL_HOST', 'smtp.office365.com'),
                'port' => env('SEVENTH_MAIL_PORT', 587),
                'encryption' => env('SEVENTH_MAIL_ENCRYPTION', 'tls'),
                'username' => env('SEVENTH_MAIL_USERNAME'),
                'password' => env('SEVENTH_MAIL_PASSWORD'),
                'from' => [
                    'address' => env('SEVENTH_MAIL_FROM_ADDRESS', 'noreply@example.com'),
                    'name' => env('SEVENTH_MAIL_FROM_NAME', 'SeventhExample'),
                ],
            ],


            

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];
