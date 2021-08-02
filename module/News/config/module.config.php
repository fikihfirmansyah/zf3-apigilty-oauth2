<?php
return [
    'service_manager' => [
        'factories' => [
            \News\V1\Rest\Contents\ContentsResource::class => \News\V1\Rest\Contents\ContentsResourceFactory::class,
            \News\V1\Rest\Comments\CommentsResource::class => \News\V1\Rest\Comments\CommentsResourceFactory::class,
            \News\V1\Service\Contents::class => \News\V1\Service\ContentsFactory::class,
            \News\V1\Service\Listener\ContentsEventListener::class => \News\V1\Service\Listener\ContentsEventListenerFactory::class,
            \News\V1\Service\Comments::class => \News\V1\Service\CommentsFactory::class,
            \News\V1\Service\Listener\CommentsEventListener::class => \News\V1\Service\Listener\CommentsEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \News\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'News\\Hydrator\\Contents' => \News\V1\Hydrator\ContentsHydratorFactory::class,
            'News\\Hydrator\\Comments' => \News\V1\Hydrator\CommentsHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'news.rest.contents' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/contents[/:uuid]',
                    'defaults' => [
                        'controller' => 'News\\V1\\Rest\\Contents\\Controller',
                    ],
                ],
            ],
            'news.rest.comments' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/comments[/:uuid]',
                    'defaults' => [
                        'controller' => 'News\\V1\\Rest\\Comments\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'news.rest.contents',
            1 => 'news.rest.comments',
        ],
    ],
    'zf-rest' => [
        'News\\V1\\Rest\\Contents\\Controller' => [
            'listener' => \News\V1\Rest\Contents\ContentsResource::class,
            'route_name' => 'news.rest.contents',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'contents',
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
            'entity_class' => \News\Entity\Contents::class,
            'collection_class' => \News\V1\Rest\Contents\ContentsCollection::class,
            'service_name' => 'Contents',
        ],
        'News\\V1\\Rest\\Comments\\Controller' => [
            'listener' => \News\V1\Rest\Comments\CommentsResource::class,
            'route_name' => 'news.rest.comments',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'comments',
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
            'entity_class' => \News\Entity\Comments::class,
            'collection_class' => \News\V1\Rest\Comments\CommentsCollection::class,
            'service_name' => 'Comments',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'News\\V1\\Rest\\Contents\\Controller' => 'HalJson',
            'News\\V1\\Rest\\Comments\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'News\\V1\\Rest\\Contents\\Controller' => [
                0 => 'application/vnd.news.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'multipart/form-data',
            ],
            'News\\V1\\Rest\\Comments\\Controller' => [
                0 => 'application/vnd.news.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'News\\V1\\Rest\\Contents\\Controller' => [
                0 => 'application/vnd.news.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
            'News\\V1\\Rest\\Comments\\Controller' => [
                0 => 'application/vnd.news.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \News\V1\Rest\Contents\ContentsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'news.rest.contents',
                'route_identifier_name' => 'contents_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \News\V1\Rest\Contents\ContentsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'news.rest.contents',
                'route_identifier_name' => 'contents_id',
                'is_collection' => true,
            ],
            \News\V1\Rest\Comments\CommentsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'news.rest.comments',
                'route_identifier_name' => 'comments_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \News\V1\Rest\Comments\CommentsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'news.rest.comments',
                'route_identifier_name' => 'comments_id',
                'is_collection' => true,
            ],
            \News\Entity\Contents::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'news.rest.contents',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'News\\Hydrator\\Contents',
            ],
            \News\Entity\Comments::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'news.rest.comments',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'News\\Hydrator\\Comments',
            ],
        ],
    ],
    'zf-content-validation' => [
        'News\\V1\\Rest\\Contents\\Controller' => [
            'input_filter' => 'News\\V1\\Rest\\Contents\\Validator',
        ],
        'News\\V1\\Rest\\Comments\\Controller' => [
            'input_filter' => 'News\\V1\\Rest\\Comments\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'News\\V1\\Rest\\Contents\\Validator' => [
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
                'name' => 'titles',
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
                'name' => 'articles',
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
                'name' => 'authors',
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
                'name' => 'categorys',
            ],
        ],
        'News\\V1\\Rest\\Comments\\Validator' => [
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
                'name' => 'comments',
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
                'name' => 'authors',
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
                'name' => 'contents',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'News\\V1\\Rest\\Contents\\Controller' => [
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
        ],
    ],
];
