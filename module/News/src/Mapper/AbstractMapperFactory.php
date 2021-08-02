<?php

namespace News\Mapper;

use Aqilix\ORM\Mapper\AbstractMapperFactory as ORMAbstractMapperFactory;

/**
 * Abstract Mapper with Doctrine support
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class AbstractMapperFactory extends ORMAbstractMapperFactory
{
    protected $mapperPrefix = 'News\\Mapper';
}
