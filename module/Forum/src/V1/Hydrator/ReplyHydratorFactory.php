<?php

namespace Forum\V1\Hydrator;

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
class ReplyHydratorFactory implements FactoryInterface
{
    /**
     * Create a service for DoctrineObject Hydrator
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new \Zend\View\Helper\ServerUrl();
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $url = $helper->getScheme() . '://' . $helper->getHost();


        $hydrator = new DoctrineObject($entityManager);
        $hydrator->addStrategy('replyAttach', new Strategy\AttachStrategy($url));
        $hydrator->addStrategy('thread_body', new Strategy\ThreadStrategy());
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
