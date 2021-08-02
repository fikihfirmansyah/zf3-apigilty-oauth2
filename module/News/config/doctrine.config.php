<?php
return [
    'doctrine' => [
        'driver' => [
            'news_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/orm']
            ],
            'orm_default' => [
                'drivers' => [
                    'News\Entity' => 'news_entity',
                ]
            ]
        ],
    ],
];
