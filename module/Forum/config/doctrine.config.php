<?php
return [
    'doctrine' => [
        'driver' => [
            'forum_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Forum\Entity' => 'forum_entity',
                ]
            ]
        ],
    ],
];
