<?php
return [
    'service_manager' => [
        'factories' => [
            \Berita\V1\Rest\Konten\KontenResource::class => \Berita\V1\Rest\Konten\KontenResourceFactory::class,
            \Berita\V1\Rest\Komentar\KomentarResource::class => \Berita\V1\Rest\Komentar\KomentarResourceFactory::class,
            \Berita\V1\Service\Konten::class => \Berita\V1\Service\KontenFactory::class,
            \Berita\V1\Service\Listener\KontenEventListener::class => \Berita\V1\Service\Listener\KontenEventListenerFactory::class,
            \Berita\V1\Service\Komentar::class => \Berita\V1\Service\KomentarFactory::class,
            \Berita\V1\Service\Listener\KomentarEventListener::class => \Berita\V1\Service\Listener\KomentarEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \Berita\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Berita\\Hydrator\\Konten' => \Berita\V1\Hydrator\KontenHydratorFactory::class,
            'Berita\\Hydrator\\Komentar' => \Berita\V1\Hydrator\KomentarHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'berita.rest.konten' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/konten[/:uuid]',
                    'defaults' => [
                        'controller' => 'Berita\\V1\\Rest\\Konten\\Controller',
                    ],
                ],
            ],
            'berita.rest.komentar' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/komentar[/:uuid]',
                    'defaults' => [
                        'controller' => 'Berita\\V1\\Rest\\Komentar\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'berita.rest.konten',
            1 => 'berita.rest.komentar',
        ],
    ],
    'zf-rest' => [
        'Berita\\V1\\Rest\\Konten\\Controller' => [
            'listener' => \Berita\V1\Rest\Konten\KontenResource::class,
            'route_name' => 'berita.rest.konten',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'konten',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'limit',
            ],
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => \Berita\Entity\Konten::class,
            'collection_class' => \Berita\V1\Rest\Konten\KontenCollection::class,
            'service_name' => 'Konten',
        ],
        'Berita\\V1\\Rest\\Komentar\\Controller' => [
            'listener' => \Berita\V1\Rest\Komentar\KomentarResource::class,
            'route_name' => 'berita.rest.komentar',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'komentar',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Berita\Entity\Komentar::class,
            'collection_class' => \Berita\V1\Rest\Komentar\KomentarCollection::class,
            'service_name' => 'Komentar',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Berita\\V1\\Rest\\Konten\\Controller' => 'HalJson',
            'Berita\\V1\\Rest\\Komentar\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Berita\\V1\\Rest\\Konten\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
            'Berita\\V1\\Rest\\Komentar\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Berita\\V1\\Rest\\Konten\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'Berita\\V1\\Rest\\Komentar\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Berita\V1\Rest\Konten\KontenEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'berita.rest.konten',
                'route_identifier_name' => 'konten_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Berita\V1\Rest\Konten\KontenCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'berita.rest.konten',
                'route_identifier_name' => 'konten_id',
                'is_collection' => true,
            ],
            \Berita\V1\Rest\Komentar\KomentarEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'berita.rest.komentar',
                'route_identifier_name' => 'komentar_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Berita\V1\Rest\Komentar\KomentarCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'berita.rest.komentar',
                'route_identifier_name' => 'komentar_id',
                'is_collection' => true,
            ],
            \Berita\Entity\Konten::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'berita.rest.konten',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Berita\\Hydrator\\Konten',
            ],
            \Berita\Entity\Komentar::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'berita.rest.komentar',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Berita\\Hydrator\\Komentar',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Berita\\V1\\Rest\\Konten\\Controller' => [
            'input_filter' => 'Berita\\V1\\Rest\\Konten\\Validator',
        ],
        'Berita\\V1\\Rest\\Komentar\\Controller' => [
            'input_filter' => 'Berita\\V1\\Rest\\Komentar\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Berita\\V1\\Rest\\Konten\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '100',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'judul',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '100',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'isi',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'penulis',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'kategori',
            ],
            4 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'randomize' => true,
                            'use_upload_extension' => true,
                            'target' => 'data/foto/konten',
                        ],
                    ],
                ],
                'name' => 'foto',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
        ],
        'Berita\\V1\\Rest\\Komentar\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'komentar',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'penulis',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'konten',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Berita\\V1\\Rest\\Konten\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'Berita\\V1\\Rest\\Komentar\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
