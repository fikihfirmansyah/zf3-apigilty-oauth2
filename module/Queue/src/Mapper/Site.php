<?php

namespace Queue\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Site mapper.
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class Site extends AbstractMapper implements MapperInterface
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

        return $em->getRepository('Queue\\Entity\\Site');
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
        $query->useResultCache(true, 600, 'queue_site_');

        return $query;
    }

    /**
     * Get total queue per site.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getTotalPerSite(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $qb->leftJoin('c.devices', 'd')
            ->leftJoin('d.logDailySummaries', 'e');

        $qb->select(
            'c.name AS site,' .
                'SUM(e.totalQueue) AS totalQueue'
        )
            ->groupBy('c.uuid');

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $qb->where('e.date IS NULL')
                ->orWhere('e.date >= :start_date AND e.date <= :end_date')
                ->setParameter('start_date', $params['start_date'])
                ->setParameter('end_date', $params['end_date']);
        }

        $query = $qb->getQuery();

        return $query;
    }

    /**
     * Get total queue per site.
     * This time using native query.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getTotalPerSite2(array $params)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('site', 'site');
        $rsm->addScalarResult('total_queue', 'totalQueue');

        $em = $this->getEntityManager();

        $siteTable = $em->getClassMetadata(\Queue\Entity\Site::class)
            ->getTableName();
        $deviceTable = $em->getClassMetadata(\Queue\Entity\Device::class)
            ->getTableName();
        $summaryTable = $em->getClassMetadata(\Queue\Entity\LogDailySummary::class)
            ->getTableName();

        $date = '';
        if (isset($params['start_date']) && isset($params['end_date'])) {
            $date = <<<SQL
                        AND `e`.`date` >= :start_date
                        AND `e`.`date` <= :end_date
                    SQL;
        }

        $qb = $em->createNativeQuery(<<<SQL
                    SELECT
                        `c`.`name` AS `site`,
                        SUM(`e`.`total_queue`) AS `total_queue`
                    FROM
                        $siteTable AS `c`
                    L   EFT JOIN
                        $deviceTable AS `d`
                            ON `c`.`uuid` = `d`.`site_uuid`
                            AND `d`.`deleted_at` IS NULL
                    LEFT JOIN
                        $summaryTable AS `e`
                            ON `d`.`uuid` = `e`.`device_uuid`
                            AND `e`.`deleted_at` IS NULL
                            $date
                    GROUP BY
                        `c`.`uuid`
                SQL, $rsm);

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $qb->setParameter('start_date', $params['start_date'])
                ->setParameter('end_date', $params['end_date']);
        }

        return $qb;
    }

    /**
     * Get queue average waiting time per site.
     * This time using native query.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getAvgWaitingTimePerSite(array $params)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('site', 'site');
        $rsm->addScalarResult('avg_waiting_time', 'avgWaitingTime');

        $em = $this->getEntityManager();

        $siteTable = $em->getClassMetadata(\Queue\Entity\Site::class)
            ->getTableName();
        $deviceTable = $em->getClassMetadata(\Queue\Entity\Device::class)
            ->getTableName();
        $summaryTable = $em->getClassMetadata(\Queue\Entity\LogDailySummary::class)
            ->getTableName();

        $date = '';
        if (isset($params['start_date']) && isset($params['end_date'])) {
            $date = <<<SQL
                        AND `e`.`date` >= :start_date
                        AND `e`.`date` <= :end_date
                    SQL;
        }

        $qb = $em->createNativeQuery(<<<SQL
                    SELECT
                        `c`.`name` AS `site`,
                        AVG(`e`.`avg_waiting_time`) AS `avg_waiting_time`
                    FROM
                        $siteTable AS `c`
                    LEFT JOIN
                        $deviceTable AS `d`
                            ON `c`.`uuid` = `d`.`site_uuid`
                            AND `d`.`deleted_at` IS NULL
                    LEFT JOIN
                        $summaryTable AS `e`
                            ON `d`.`uuid` = `e`.`device_uuid`
                            AND `e`.`deleted_at` IS NULL
                            $date
                    GROUP BY
                        `c`.`uuid`
                SQL, $rsm);

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $qb->setParameter('start_date', $params['start_date'])
                ->setParameter('end_date', $params['end_date']);
        }

        return $qb;
    }
}
