<?php

namespace News\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Comments mapper.
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class Comments extends AbstractMapper implements MapperInterface
{
    /**
     * Get the entity repository.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        $em = $this->getEntityManager();
        $emConfig = $em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('DATE', \DoctrineExtensions\Query\Mysql\Date::class);

        return $em->getRepository('News\\Entity\\Comments');
    }

    /**
     * Fetch multiple records with params.
     *
     * @param  array  $params
     * @param  mixed  $order
     * @param  bool  $asc
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll(array $params, $order = null, $asc = false)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');

        $sort = $asc ? 'ASC' : 'DESC';
        if ($order)
            $qb->orderBy('c.' . $order, $sort);
        else
            $qb->orderBy('c.createdAt', $sort);

        $query = $qb->getQuery();

        $query->useQueryCache(true);
        $query->useResultCache(true, 600, 'news_comments_');

        return $query;
    }
}
