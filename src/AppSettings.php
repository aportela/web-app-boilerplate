<?php
    declare(strict_types=1);

    return [
        'settings' => [
            'displayErrorDetails' => true, // set to false in production
            'addContentLengthHeader' => false, // Allow the web server to send the content-length header
            'twigParams' => [
                'production' => false,
                'localVendorAssets' => true // use local vendor assets (vs remote cdn)
            ],
            // database settings
            'database' => [
                'connectionString' => sprintf("sqlite:%s", dirname(__DIR__) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "foobar.sqlite3"),
                'username' => '',
                'password' => ''
            ],
            // Renderer settings
            'renderer' => [
                'template_path' => __DIR__ . '/../templates',
            ],
            // Monolog settings
            'logger' => [
                'name' => 'foobar-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/default.log',
                'level' => \Monolog\Logger::DEBUG
            ],
            'databaseLogger' => [
                'name' => 'foobar-db',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/database.log',
                'level' => \Monolog\Logger::DEBUG
            ],
            'apiLogger' => [
                'name' => 'foobar-api',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/api.log',
                'level' => \Monolog\Logger::DEBUG
            ]
        ],
    ];
?>