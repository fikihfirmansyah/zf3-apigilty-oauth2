<?php

namespace Forum\Mapper;

use Aqilix\ORM\Mapper\AbstractMapperFactory as ORMAbstractMapperFactory;

/**
 * Thread mapper.
 *
 * @author Fikih Firmansyah <fikihfirmansyah43@gmail.com>
 */
class AbstractMapperFactory extends ORMAbstractMapperFactory
{
    protected $mapperPrefix = 'Forum\\Mapper';
}
