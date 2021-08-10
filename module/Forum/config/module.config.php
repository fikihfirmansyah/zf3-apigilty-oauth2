<?php
return [
    'service_manager' => [
        'factories' => [
            \Forum\V1\Rest\ForumThread\ForumThreadResource::class => \Forum\V1\Rest\ForumThread\ForumThreadResourceFactory::class,
            \Forum\V1\Rest\ForumReply\ForumReplyResource::class => \Forum\V1\Rest\ForumReply\ForumReplyResourceFactory::class,
            \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedResource::class => \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedResourceFactory::class,
            \Forum\V1\Service\Thread::class => \Forum\V1\Service\ThreadFactory::class,
            \Forum\V1\Service\Listener\ThreadEventListener::class => \Forum\V1\Service\Listener\ThreadEventListenerFactory::class,
            \Forum\V1\Service\Reply::class => \Forum\V1\Service\ReplyFactory::class,
            \Forum\V1\Service\Listener\ReplyEventListener::class => \Forum\V1\Service\Listener\ReplyEventListenerFactory::class,
            \Forum\V1\Service\ReplyNested::class => \Forum\V1\Service\ReplyNestedFactory::class,
            \Forum\V1\Service\Listener\ReplyNestedEventListener::class => \Forum\V1\Service\Listener\ReplyNestedEventListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \Forum\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Forum\\Hydrator\\Thread' => \Forum\V1\Hydrator\ThreadHydratorFactory::class,
            'Forum\\Hydrator\\Reply' => \Forum\V1\Hydrator\ReplyHydratorFactory::class,
            'Forum\\Hydrator\\ReplyNested' => \Forum\V1\Hydrator\ReplyNestedHydratorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'forum.rest.forum-thread' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/forum-thread[/:uuid]',
                    'defaults' => [
                        'controller' => 'Forum\\V1\\Rest\\ForumThread\\Controller',
                    ],
                ],
            ],
            'forum.rest.forum-reply' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/forum-reply[/:uuid]',
                    'defaults' => [
                        'controller' => 'Forum\\V1\\Rest\\ForumReply\\Controller',
                    ],
                ],
            ],
            'forum.rest.forum-reply-nested' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/forum-reply-nested[/:uuid]',
                    'defaults' => [
                        'controller' => 'Forum\\V1\\Rest\\ForumReplyNested\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'forum.rest.forum-thread',
            1 => 'forum.rest.forum-reply',
            2 => 'forum.rest.forum-reply-nested',
        ],
    ],
    'zf-rest' => [
        'Forum\\V1\\Rest\\ForumThread\\Controller' => [
            'listener' => \Forum\V1\Rest\ForumThread\ForumThreadResource::class,
            'route_name' => 'forum.rest.forum-thread',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'b',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'body',
                1 => 'searchTitle',
                2 => 'limit',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Forum\Entity\Thread::class,
            'collection_class' => \Forum\V1\Rest\ForumThread\ForumThreadCollection::class,
            'service_name' => 'ForumThread',
        ],
        'Forum\\V1\\Rest\\ForumReply\\Controller' => [
            'listener' => \Forum\V1\Rest\ForumReply\ForumReplyResource::class,
            'route_name' => 'forum.rest.forum-reply',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'forum_reply',
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
            'entity_class' => \Forum\Entity\Reply::class,
            'collection_class' => \Forum\V1\Rest\ForumReply\ForumReplyCollection::class,
            'service_name' => 'ForumReply',
        ],
        'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => [
            'listener' => \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedResource::class,
            'route_name' => 'forum.rest.forum-reply-nested',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'forum_reply_nested',
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
            'entity_class' => \Forum\Entity\ReplyNested::class,
            'collection_class' => \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedCollection::class,
            'service_name' => 'ForumReplyNested',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Forum\\V1\\Rest\\ForumThread\\Controller' => 'HalJson',
            'Forum\\V1\\Rest\\ForumReply\\Controller' => 'HalJson',
            'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Forum\\V1\\Rest\\ForumThread\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
            'Forum\\V1\\Rest\\ForumReply\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
            'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => [
                0 => 'application/vnd.forum.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
                3 => 'multipart/form-data',
            ],
        ],
        'content_type_whitelist' => [
            'Forum\\V1\\Rest\\ForumThread\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'Forum\\V1\\Rest\\ForumReply\\Controller' => [
                0 => 'application/json',
                1 => 'multipart/form-data',
            ],
            'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => [
                0 => 'application/vnd.forum.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Forum\V1\Rest\ForumThread\ForumThreadEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-thread',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Forum\\Hydrator\\Thread',
            ],
            \Forum\V1\Rest\ForumThread\ForumThreadCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-thread',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \Forum\V1\Rest\ForumReply\ForumReplyEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Forum\\Hydrator\\Reply',
            ],
            \Forum\V1\Rest\ForumReply\ForumReplyCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedEntity::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply-nested',
                'route_identifier_name' => 'uuid',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Forum\V1\Rest\ForumReplyNested\ForumReplyNestedCollection::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply-nested',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \Forum\Entity\Thread::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-thread',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Forum\\Hydrator\\Thread',
            ],
            \Forum\Entity\Reply::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Forum\\Hydrator\\Reply',
            ],
            \Forum\Entity\ReplyNested::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'forum.rest.forum-reply-nested',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Forum\\Hydrator\\ReplyNested',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Forum\\V1\\Rest\\ForumThread\\Controller' => [
            'input_filter' => 'Forum\\V1\\Rest\\ForumThread\\Validator',
        ],
        'Forum\\V1\\Rest\\ForumReply\\Controller' => [
            'input_filter' => 'Forum\\V1\\Rest\\ForumReply\\Validator',
        ],
        'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => [
            'input_filter' => 'Forum\\V1\\Rest\\ForumReplyNested\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Forum\\V1\\Rest\\ForumThread\\Validator' => [
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
                'name' => 'threadTitle',
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
                'name' => 'threadBody',
            ],
            2 => [
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
                'name' => 'threadTags',
            ],
            3 => [
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
                'name' => 'threadAuthor',
            ],
            4 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\File\Extension::class,
                        'options' => [
                            'extension' => 'png',
                        ],
                    ],
                    1 => [
                        'name' => \Zend\Validator\File\MimeType::class,
                        'options' => [
                            'mimeType' => 'image/png',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\File\RenameUpload::class,
                        'options' => [
                            'target' => 'data/foto/thread',
                            'randomize' => true,
                            'use_upload_extension' => true,
                        ],
                    ],
                ],
                'name' => 'threadAttach',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
            5 => [
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
                'name' => 'threadCategory',
            ],
        ],
        'Forum\\V1\\Rest\\ForumReply\\Validator' => [
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
                'name' => 'replyBody',
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
                'name' => 'replyAuthor',
            ],
            2 => [
                'required' => false,
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
                            'target' => 'data/foto/reply',
                            'use_upload_extension' => true,
                        ],
                    ],
                ],
                'name' => 'replyAttach',
                'type' => \Zend\InputFilter\FileInput::class,
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'thread',
            ],
        ],
        'Forum\\V1\\Rest\\ForumReplyNested\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'replyNestedBody',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\I18n\Validator\Alnum::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'replyNestedAuthor',
            ],
            2 => [
                'required' => false,
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
                            'target' => 'data/foto/replynested',
                        ],
                    ],
                ],
                'name' => 'replyNestedAttach',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'reply',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Forum\\V1\\Rest\\ForumThread\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'Forum\\V1\\Rest\\ForumReply\\Controller' => [
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
            'Forum\\V1\\Rest\\ForumReplyNested\\Controller' => [
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
