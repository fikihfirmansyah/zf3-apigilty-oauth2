<?php

namespace Queue\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;

/**
 * LogDailySummary mapper.
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class LogDailySummary extends AbstractMapper implements MapperInterface
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

        return $em->getRepository('Queue\\Entity\\LogDailySummary');
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
        if($order)
            $qb->orderBy('c.'.$order, $sort);
        else
            $qb->orderBy('c.createdAt', $sort);

        $query = $qb->getQuery();

        $query->useQueryCache(true);
        $query->useResultCache(true, 600, 'queue_log_daily_summary_');

        return $query;
    }

    /**
     * Get statistics data.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getStats(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');

        $qb->join('c.device', 'd')
            ->join('d.site', 'e')
            ->select(
                'e.uuid AS siteUuid,'.
                'e.name AS siteName,'.
                'd.name AS deviceName,'.
                'd.uuid AS deviceUuid,'.
                'c.counterNumber,'.
                'SUM(c.totalQueue) AS totalQueue,'.
                'AVG(c.avgWaitingTime) as avgWaitingTime,'.
                'AVG(c.avgProcessingTime) as avgProcessingTime'
            )
            ->groupBy('e.uuid, d.uuid, c.counterNumber');

        if(isset($params['site_uuid']))
            $qb->andWhere('e.uuid = :site_uuid')
                ->setParameter('site_uuid', $params['site_uuid']);

        if(isset($params['device_uuid']))
            $qb->andWhere('d.uuid = :device_uuid')
                ->setParameter('device_uuid', $params['device_uuid']);

        if(isset($params['date'])) {
            try {
                $qb->andWhere('DATE(c.date) = :date')
                    ->setParameter('date', new \DateTime($params['date']));
            } catch(\Exception $ex) {
                throw new \Exception('Date parameter is not a valid date');
            }
        } else {
            if(isset($params['start_date'])) {
                try {
                    $qb->andWhere('DATE(c.date) >= :start_date')
                        ->setParameter('start_date', new \DateTime($params['start_date']));
                } catch(\Exception $ex) {
                    throw new \Exception('Start date parameter is not a valid date');
                }
            }
            if(isset($params['end_date'])) {
                try {
                    $qb->andWhere('DATE(c.date) <= :end_date')
                        ->setParameter('end_date', new \DateTime($params['end_date']));
                } catch(\Exception $ex) {
                    throw new \Exception('End date parameter is not a valid date');
                }
            }
        }

        $query = $qb->getQuery();

        return $query;
    }

    /**
     * Get statistics data grouped by date.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getStatsByDate(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');

        $qb->select(
                'c.date AS date,'.
                'SUM(c.totalQueue) AS totalQueue,'.
                'AVG(c.avgWaitingTime) as avgWaitingTime,'.
                'AVG(c.avgProcessingTime) as avgProcessingTime'
            )
            ->groupBy('c.date');

        if(isset($params['limit'])) {
            $qb->setMaxResults((int)$params['limit']);
        }

        if(isset($params['date'])) {
            $qb->andWhere('c.date = :date')
                ->setParameter('date', $params['date']);
        }

        $query = $qb->getQuery();

        return $query;
    }

    /**
     * Get total queue per counter.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getTotalPerCounter(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $qb->join('c.device', 'd')
            ->join('d.site', 'e');

        $qb->select(
                'e.name AS site,'.
                'd.name AS device,'.
                'c.counterNumber,'.
                'SUM(c.totalQueue) AS totalQueue'
            )
            ->groupBy('c.counterNumber');

        if(isset($params['start_date']) && isset($params['end_date'])) {
            $qb->andWhere('c.date >= :start_date')
                ->setParameter('start_date', $params['start_date']);
            $qb->andWhere('c.date <= :end_date')
                ->setParameter('end_date', $params['end_date']);
        }

        if(isset($params['device'])) {
            $qb->andWhere('d.uuid = :device')
                ->setParameter('device', $params['device']);
        } else if(isset($params['site'])) {
            $qb->andWhere('e.uuid = :site')
                ->setParameter('site', $params['site']);
        }

        $query = $qb->getQuery();

        return $query;
    }

    /**
     * Get average waiting time per site.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getAvgWaitingTimePerSite(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $qb->join('c.device', 'd')
            ->join('d.site', 'e');

        $qb->select(
                'c.date AS date,'.
                'e.name AS site,'.
                'AVG(c.avgWaitingTime) AS avgWaitingTime'
            )
            ->groupBy('c.date, d.site');

        if(isset($params['start_date']) && isset($params['end_date'])) {
            $qb->andWhere('c.date >= :start_date')
                ->setParameter('start_date', $params['start_date']);
            $qb->andWhere('c.date <= :end_date')
                ->setParameter('end_date', $params['end_date']);
        }

        if(isset($params['site'])) {
            $qb->andWhere('e.uuid = :site')
                ->setParameter('site', $params['site']);
        }

        $query = $qb->getQuery();

        return $query;
    }
}
