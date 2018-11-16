<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
         // Database connection settings           
          "db" => [
            "host" => "ec2-184-73-169-151.compute-1.amazonaws.com",
            "dbname" => "d8pf6at6nh6aul",
            "user" => "nkxcztlawlguxz",
            "pass" => "28c202d53f6f4858eaec6782dd9704c8e8c4d3b66b530f2cbc589c620b38dcb1",
            "port" => 5432
        ],
    ],
];
?>