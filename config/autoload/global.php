<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'charset'        => 'UTF8', // Supported by ZF2 in dev branch
        'driver'         => 'pdo_mysql',
        'driver_options' => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8',sql_mode=TRADITIONAL"], // TODO: remove when ZF2 will support charset
    ],

    'development' => [
        'db' => [
            'database' => 'my_db_dev',
        ],
    ],

    'production' => [
        'db' => [
            'database' => 'my_db_prod',
        ],
    ],

    'testing' => [
        'db' => [
            'database' => 'my_db_test',
        ],
    ],
];
