<?php
return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'mysql',
                    'port'     => '3306',
                    'user'     => 'xtend',
                    'password' => 'xtend',
                    'dbname'   => '',
                    'charset'  => 'utf8'
                ],
            ],
        ],
    ],
];
