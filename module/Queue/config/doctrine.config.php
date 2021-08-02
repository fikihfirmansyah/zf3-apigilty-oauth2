<?php
return [
    'doctrine' => [
        'driver' => [
            'queue_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Queue\Entity' => 'queue_entity',
                ]
            ]
        ],
    ],
];
