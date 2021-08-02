<?php
return [
    'reset_password' => [
        'expiration' => '14',
    ],
    'controllers' => [
        'factories' => [
            'User\\V1\\Rpc\\Me\\Controller' => \User\V1\Rpc\Me\MeControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'user.auth.pdo.adapter' => \User\OAuth2\Factory\PdoAdapterFactory::class,
            'user.auth.activeuser.listener' => \User\Service\Listener\AuthActiveUserListenerFactory::class,
            'user.auth.unauthorized.listener' => \User\Service\Listener\UnauthorizedUserListenerFactory::class,
            'user.authentication.timezone.listener' => \User\Service\Listener\AuthenticationTimezoneListenerFactory::class,
            'User\\V1\\Rest\\Profile\\ProfileResource' => 'User\\V1\\Rest\\Profile\\ProfileResourceFactory',
            \User\Service\Listener\ClientAuthorizationListener::class => \User\Service\Listener\ClientAuthorizationListenerFactory::class,
        ],
        'abstract_factories' => [
            0 => \User\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
        ],
    ],
    'router' => [
        'routes' => [
            'user.rpc.me' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/me',
                    'defaults' => [
                        'controller' => 'User\\V1\\Rpc\\Me\\Controller',
                        'action' => 'me',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            1 => 'user.rpc.me',
        ],
    ],
    'zf-rpc' => [
        'User\\V1\\Rpc\\Me\\Controller' => [
            'service_name' => 'Me',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'user.rpc.me',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'User\\V1\\Rpc\\Me\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'User\\V1\\Rpc\\Me\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-content-validation' => [],
    'input_filter_specs' => [],
    'zf-rest' => [],
    'zf-hal' => [
        'metadata_map' => [],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'User\\V1\\Rpc\\Me\\Controller' => [
                'actions' => [
                    'me' => [
                        'GET' => false,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
        ],
    ],
];
