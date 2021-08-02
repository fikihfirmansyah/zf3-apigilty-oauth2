<?php
return [
    'doctrine' => [
        'driver' => [
            'berita_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'Berita\Entity' => 'berita_entity',
                ]
            ]
        ],
    ],
];
