<?php
namespace Queue\V1\Hydrator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\Strategy\DateTimeFormatterStrategy;
use Zend\Hydrator\Filter\FilterComposite;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Hydrator for Doctrine Entity
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class LogHydratorFactory implements FactoryInterface
{
    /**
     * Create a service for DoctrineObject Hydrator
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $hydrator = new DoctrineObject($entityManager);
        $hydrator->addStrategy('processingTime', new Strategy\MinuteStrategy());
        $hydrator->addStrategy('waitingTime', new Strategy\MinuteStrategy());
        $hydrator->addStrategy('device', new Strategy\DeviceStrategy());
        $hydrator->addStrategy('reservedTime', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('calledTime', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('endTime', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('createdAt', new DateTimeFormatterStrategy('c'));
        $hydrator->addStrategy('updatedAt', new DateTimeFormatterStrategy('c'));

        $hydrator->addFilter('exclude', function ($property) {
            if (in_array($property, ['deletedAt']))
                return false;
            return true;
        }, FilterComposite::CONDITION_AND);

        return $hydrator;
    }
}
