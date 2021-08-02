<?php
return [
    'service_manager' => [
        'factories' => [
            \Queue\V1\Rest\QueueLog\QueueLogResource::class => \Queue\V1\Rest\QueueLog\QueueLogResourceFactory::class,
            \Queue\V1\Service\Log::class => \Queue\V1\Service\LogFactory::class,
            \Queue\V1\Service\Listener\LogEventListener::class => \Queue\V1\Service\Listener\LogEventListenerFactory::class,
            \Queue\V1\Rest\QueueSite\QueueSiteResource::class => \Queue\V1\Rest\QueueSite\QueueSiteResourceFactory::class,
            \Queue\V1\Service\Site::class => \Queue\V1\Service\SiteFactory::class,
            \Queue\V1\Service\Listener\SiteEventListener::class => \Queue\V1\Service\Listener\SiteEventListenerFactory::class,
            \Queue\V1\Rest\QueueDevice\QueueDeviceResource::class => \Queue\V1\Rest\QueueDevice\QueueDeviceResourceFactory::class,
            \Queue\V1\Service\Device::class => \Queue\V1\Service\DeviceFactory::class,
            \Queue\V1\Service\Listener\DeviceEventListener::class => \Queue\V1\Service\Listener\DeviceEventListenerFactory::class,
            \Queue\Export\Service\CsvExport::class => \Queue\Export\Service\CsvExportFactory::class,
        ],
        'abstract_factories' => [
            0 => \Queue\Mapper\AbstractMapperFactory::class,
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Queue\\Hydrator\\Log' => \Queue\V1\Hydrator\LogHydratorFactory::class,
            'Queue\\Hydrator\\Site' => \Queue\V1\Hydrator\SiteHydratorFactory::class,
            'Queue\\Hydrator\\Device' => \Queue\V1\Hydrator\DeviceHydratorFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            0 => __DIR__ . '/../view',
        ],
    ],
    'router' => [
        'routes' => [
            'queue.rest.queue-log' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/queue-log[/:uuid]',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rest\\QueueLog\\Controller',
                    ],
                ],
            ],
            'queue.rest.queue-site' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/queue-site[/:uuid]',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rest\\QueueSite\\Controller',
                    ],
                ],
            ],
            'queue.rest.queue-device' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/queue-device[/:uuid]',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rest\\QueueDevice\\Controller',
                    ],
                ],
            ],
            'queue.rpc.stats-per-site' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/stats-per-site',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\StatsPerSite\\Controller',
                        'action' => 'statsPerSite',
                    ],
                ],
            ],
            'queue.rpc.stats-per-date' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/stats-per-date',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\StatsPerDate\\Controller',
                        'action' => 'statsPerDate',
                    ],
                ],
            ],
            'queue.rpc.total-per-counter' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/total-per-counter',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\TotalPerCounter\\Controller',
                        'action' => 'totalPerCounter',
                    ],
                ],
            ],
            'queue.rpc.total-per-site' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/total-per-site',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\TotalPerSite\\Controller',
                        'action' => 'totalPerSite',
                    ],
                ],
            ],
            'queue.rpc.export-queue' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/export-queue-[:action]',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\ExportQueue\\Controller',
                        'action' => 'exportQueue',
                    ],
                ],
            ],
            'queue.rpc.waiting-time-per-date' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/waiting-time-per-date',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller',
                        'action' => 'waitingTimePerDate',
                    ],
                ],
            ],
            'queue.rpc.export-queue-summary' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/api/v1/export-queue-summary-[:action]',
                    'defaults' => [
                        'controller' => 'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller',
                        'action' => 'exportQueueSummary',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'queue.rest.queue-log',
            1 => 'queue.rest.queue-site',
            2 => 'queue.rest.queue-device',
            3 => 'queue.rpc.stats-per-site',
            4 => 'queue.rpc.stats-per-date',
            5 => 'queue.rpc.total-per-counter',
            6 => 'queue.rpc.total-per-site',
            7 => 'queue.rpc.export-queue',
            8 => 'queue.rpc.waiting-time-per-date',
            9 => 'queue.rpc.export-queue-summary',
        ],
    ],
    'zf-rest' => [
        'Queue\\V1\\Rest\\QueueLog\\Controller' => [
            'listener' => \Queue\V1\Rest\QueueLog\QueueLogResource::class,
            'route_name' => 'queue.rest.queue-log',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'queue_log',
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
                0 => 'site_uuid',
                1 => 'device_uuid',
                2 => 'start_date',
                3 => 'end_date',
                4 => 'counter',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Queue\Entity\Log::class,
            'collection_class' => \Zend\Paginator\Paginator::class,
            'service_name' => 'QueueLog',
        ],
        'Queue\\V1\\Rest\\QueueSite\\Controller' => [
            'listener' => \Queue\V1\Rest\QueueSite\QueueSiteResource::class,
            'route_name' => 'queue.rest.queue-site',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'queue_site',
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
            'entity_class' => \Queue\Entity\Site::class,
            'collection_class' => \Zend\Paginator\Paginator::class,
            'service_name' => 'QueueSite',
        ],
        'Queue\\V1\\Rest\\QueueDevice\\Controller' => [
            'listener' => \Queue\V1\Rest\QueueDevice\QueueDeviceResource::class,
            'route_name' => 'queue.rest.queue-device',
            'route_identifier_name' => 'uuid',
            'collection_name' => 'queue_device',
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
            'entity_class' => \Queue\Entity\Device::class,
            'collection_class' => \Zend\Paginator\Paginator::class,
            'service_name' => 'QueueDevice',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Queue\\V1\\Rest\\QueueLog\\Controller' => 'HalJson',
            'Queue\\V1\\Rest\\QueueSite\\Controller' => 'HalJson',
            'Queue\\V1\\Rest\\QueueDevice\\Controller' => 'HalJson',
            'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\ExportQueue\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => 'Json',
            'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'Queue\\V1\\Rest\\QueueLog\\Controller' => [
                0 => 'application/x-www-form-urlencoded',
            ],
            'Queue\\V1\\Rest\\QueueSite\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'Queue\\V1\\Rest\\QueueDevice\\Controller' => [
                0 => 'application/hal+json',
                1 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\ExportQueue\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
            'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => [
                0 => 'application/json',
                1 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'Queue\\V1\\Rest\\QueueLog\\Controller' => [
                0 => 'application/json',
                1 => 'application/x-www-form-urlencoded',
            ],
            'Queue\\V1\\Rest\\QueueSite\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rest\\QueueDevice\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\ExportQueue\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => [
                0 => 'application/json',
            ],
            'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => [
                0 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Zend\Paginator\Paginator::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'queue.rest.queue-log',
                'route_identifier_name' => 'uuid',
                'is_collection' => true,
            ],
            \Queue\Entity\Log::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'queue.rest.queue-log',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Queue\\Hydrator\\Log',
            ],
            \Queue\Entity\Site::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'queue.rest.queue-site',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Queue\\Hydrator\\Site',
            ],
            \Queue\Entity\Device::class => [
                'entity_identifier_name' => 'uuid',
                'route_name' => 'queue.rest.queue-device',
                'route_identifier_name' => 'uuid',
                'hydrator' => 'Queue\\Hydrator\\Device',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Queue\\V1\\Rest\\QueueLog\\Controller' => [
            'input_filter' => 'Queue\\V1\\Rest\\QueueLog\\Validator',
        ],
        'Queue\\V1\\Rest\\QueueSite\\Controller' => [
            'input_filter' => 'Queue\\V1\\Rest\\QueueSite\\Validator',
        ],
        'Queue\\V1\\Rest\\QueueDevice\\Controller' => [
            'input_filter' => 'Queue\\V1\\Rest\\QueueDevice\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Queue\\V1\\Rest\\QueueLog\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'deviceId',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'number',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'counter',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'printTicketTime',
            ],
            4 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'calledTime',
            ],
            5 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'endTime',
            ],
        ],
        'Queue\\V1\\Rest\\QueueSite\\Validator' => [
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
                'name' => 'name',
                'field_type' => '',
            ],
            1 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'description',
            ],
        ],
        'Queue\\V1\\Rest\\QueueDevice\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\Uuid::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'site',
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
                'name' => 'name',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'description',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Queue\\V1\\Rest\\QueueLog\\Controller' => [
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
            'Queue\\V1\\Rest\\QueueSite\\Controller' => [
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
            'Queue\\V1\\Rest\\QueueDevice\\Controller' => [
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
            'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => [
                'actions' => [
                    'statsPerSite' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => [
                'actions' => [
                    'statsPerDate' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => [
                'actions' => [
                    'totalPerCounter' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => [
                'actions' => [
                    'totalPerSite' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\ExportQueue\\Controller' => [
                'actions' => [
                    'exportQueue' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => [
                'actions' => [
                    'waitingTimePerDate' => [
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ],
                ],
            ],
            'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => [
                'actions' => [
                    'exportQueueSummary' => [
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
    'controllers' => [
        'factories' => [
            'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => \Queue\V1\Rpc\StatsPerSite\StatsPerSiteControllerFactory::class,
            'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => \Queue\V1\Rpc\StatsPerDate\StatsPerDateControllerFactory::class,
            'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => \Queue\V1\Rpc\TotalPerCounter\TotalPerCounterControllerFactory::class,
            'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => \Queue\V1\Rpc\TotalPerSite\TotalPerSiteControllerFactory::class,
            'Queue\\V1\\Rpc\\ExportQueue\\Controller' => \Queue\V1\Rpc\ExportQueue\ExportQueueControllerFactory::class,
            'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => \Queue\V1\Rpc\WaitingTimePerDate\WaitingTimePerDateControllerFactory::class,
            'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => \Queue\V1\Rpc\ExportQueueSummary\ExportQueueSummaryControllerFactory::class,
        ],
    ],
    'zf-rpc' => [
        'Queue\\V1\\Rpc\\StatsPerSite\\Controller' => [
            'service_name' => 'StatsPerSite',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.stats-per-site',
        ],
        'Queue\\V1\\Rpc\\StatsPerDate\\Controller' => [
            'service_name' => 'StatsPerDate',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.stats-per-date',
        ],
        'Queue\\V1\\Rpc\\TotalPerCounter\\Controller' => [
            'service_name' => 'TotalPerCounter',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.total-per-counter',
        ],
        'Queue\\V1\\Rpc\\TotalPerSite\\Controller' => [
            'service_name' => 'TotalPerSite',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.total-per-site',
        ],
        'Queue\\V1\\Rpc\\ExportQueue\\Controller' => [
            'service_name' => 'ExportQueue',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.export-queue',
        ],
        'Queue\\V1\\Rpc\\WaitingTimePerDate\\Controller' => [
            'service_name' => 'WaitingTimePerDate',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.waiting-time-per-date',
        ],
        'Queue\\V1\\Rpc\\ExportQueueSummary\\Controller' => [
            'service_name' => 'ExportQueueSummary',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'queue.rpc.export-queue-summary',
        ],
    ],
];
