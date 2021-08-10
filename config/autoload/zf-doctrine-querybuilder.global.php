<?php
return [

    'zf-doctrine-querybuilder-orderby-orm' => [
        'aliases' => [
            'field' => \ZF\Doctrine\QueryBuilder\OrderBy\ORM\Field::class,
        ],
        'factories' => [
            \ZF\Doctrine\QueryBuilder\OrderBy\ORM\Field::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'zf-doctrine-querybuilder-filter-orm' => [
        'aliases' => [
            'eq' => \ZF\Doctrine\QueryBuilder\Filter\ORM\Equals::class,
        ],
        'factories' => [
            \ZF\Doctrine\QueryBuilder\Filter\ORM\Equals::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];
