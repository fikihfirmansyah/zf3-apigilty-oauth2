<?php

namespace Queue\Mapper;

use Aqilix\ORM\Mapper\AbstractMapper;
use Aqilix\ORM\Mapper\MapperInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Zend\Db\Sql\Sql;

/**
 * Log mapper.
 *
 * @author Abdul Pasaribu <abdoelrachmad@gmail.com>
 */
class Log extends AbstractMapper implements MapperInterface
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
        $emConfig->addCustomDatetimeFunction('TIMESTAMPDIFF', \DoctrineExtensions\Query\Mysql\TimestampDiff::class);

        return $em->getRepository('Queue\\Entity\\Log');
    }

    /**
     * Fetch multiple records with params.
     *
     * @param  array  $params
     * @param  mixed  $order
     * @param  bool  $asc
     * @param  int|null  $limit
     * @return \Doctrine\ORM\Query
     */
    public function fetchAll(array $params, $order = null, $asc = false, $limit = null)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');
        $qb->join('c.device', 'd');
        $qb->join('d.site', 'e');

        if(isset($params['counter'])) {
            $qb->where('c.counterNumber = :counter')
                ->setParameter('counter', $params['counter']);
        } else if(isset($params['device_uuid'])) {
            $qb->where('d.uuid = :device_uuid')
                ->setParameter('device_uuid', $params['device_uuid']);
        } else if(isset($params['site_uuid'])) {
            $qb->where('e.uuid = :site_uuid')
                ->setParameter('site_uuid', $params['site_uuid']);
        }

        if(isset($params['start_date'])) {
            try {
                $qb->andWhere('DATE(c.reservedTime) >= :start_date')
                    ->setParameter('start_date', (new \DateTime($params['start_date']))->format('Y-m-d'));
            } catch(\Exception $ex) {
                throw new \Exception('Start date parameter is not a valid date');
            }
        }
        if(isset($params['end_date'])) {
            try {
                $qb->andWhere('DATE(c.reservedTime) <= :end_date')
                    ->setParameter('end_date', (new \DateTime($params['end_date']))->format('Y-m-d'));
            } catch(\Exception $ex) {
                throw new \Exception('End date parameter is not a valid date');
            }
        }

        if(isset($params['end_number'])) {
            $qb->andWhere('c.number < :end_number')
                ->setParameter('end_number', $params['end_number']);
        }

        if(isset($params['end_time']) && $params['end_time'] === 'NULL') {
            $qb->andWhere('c.endTime IS NULL')
                ->andWhere('c.calledTime IS NOT NULL');
        }

        $sort = $asc ? 'ASC' : 'DESC';
        if($order)
            $qb->orderBy('c.'.$order, $sort);
        else
            $qb->orderBy('c.createdAt', $sort);

        if($limit)
            $qb->setMaxResults($limit);

        $query = $qb->getQuery();

        $query->useQueryCache(true);
        $query->useResultCache(true, 600, 'queue_log_');

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

        $qb->select(
                'c.counterNumber,'.
                'COUNT(c.uuid) AS totalQueue,'.
                'AVG(c.waitingTime) as avgWaitingTime,'.
                'AVG(c.processingTime) as avgProcessingTime'
            )
            ->groupBy('c.counterNumber')
            ->where('c.calledTime IS NOT NULL and c.endTime IS NOT NULL');

        if(isset($params['device_uuid']) || isset($params['site_uuid']))
            $qb->join('c.device', 'd');

        if(isset($params['site_uuid'])) {
            $qb->join('d.site', 'e')
                ->andWhere('e.uuid = :site_uuid')
                ->setParameter('site_uuid', $params['site_uuid']);
        }

        if(isset($params['device_uuid'])) {
            $qb->andWhere('d.uuid = :device_uuid')
                ->setParameter('device_uuid', $params['device_uuid']);
        }

        if(isset($params['date'])) {
            try {
                $qb->andWhere('DATE(c.reservedTime) = :date')
                    ->setParameter('date', new \DateTime($params['date']));
            } catch(\Exception $ex) {
                throw new \Exception('Date parameter is not a valid date');
            }
        } else {
            if(isset($params['start_date'])) {
                try {
                    $qb->andWhere('DATE(c.reservedTime) >= :start_date')
                        ->setParameter('start_date', new \DateTime($params['start_date']));
                } catch(\Exception $ex) {
                    throw new \Exception('Start date parameter is not a valid date');
                }
            }
            if(isset($params['end_date'])) {
                try {
                    $qb->andWhere('DATE(c.reservedTime) <= :end_date')
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
     * Get statistics data per device.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getStatsPerDevice(array $params)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('c');

        $qb->join('c.device', 'd');
        $qb->select(
                'd.uuid AS deviceUuid',
                'c.counterNumber,'.
                'COUNT(c.uuid) AS totalQueue,'.
                'AVG(c.waitingTime) as avgWaitingTime,'.
                'AVG(c.processingTime) as avgProcessingTime'
            )
            ->groupBy('d.uuid, c.counterNumber')
            ->where('c.calledTime IS NOT NULL and c.endTime IS NOT NULL');

        if(isset($params['site_uuid'])) {
            $qb->join('d.site', 'e')
                ->andWhere('e.uuid = :site_uuid')
                ->setParameter('site_uuid', $params['site_uuid']);
        }

        if(isset($params['date'])) {
            try {
                $qb->andWhere('DATE(c.reservedTime) = :date')
                    ->setParameter('date', new \DateTime($params['date']));
            } catch(\Exception $ex) {
                throw new \Exception('Date parameter is not a valid date');
            }
        } else {
            if(isset($params['start_date'])) {
                try {
                    $qb->andWhere('DATE(c.reservedTime) >= :start_date')
                        ->setParameter('start_date', new \DateTime($params['start_date']));
                } catch(\Exception $ex) {
                    throw new \Exception('Start date parameter is not a valid date');
                }
            }
            if(isset($params['end_date'])) {
                try {
                    $qb->andWhere('DATE(c.reservedTime) <= :end_date')
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
     * Get total queue per counter.
     * This time using native query.
     *
     * @param  array  $params
     * @return \Doctrine\ORM\Query
     * @throws \Exception
     */
    public function getTotalPerCounter(array $params)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('counter_number', 'counterNumber');
        $rsm->addScalarResult('total_queue', 'totalQueue');

        $em = $this->getEntityManager();

        $logTable = $em->getClassMetadata(\Queue\Entity\Log::class)
                        ->getTableName();
        $deviceTable = $em->getClassMetadata(\Queue\Entity\Device::class)
                        ->getTableName();
        $siteTable = $em->getClassMetadata(\Queue\Entity\Site::class)
                        ->getTableName();
        $summaryTable = $em->getClassMetadata(\Queue\Entity\LogDailySummary::class)
                        ->getTableName();

        $date = '';
        if(isset($params['start_date']) && isset($params['end_date'])) {
            $date = <<<SQL
                        AND `f`.`date` >= :start_date
                        AND `f`.`date` <= :end_date
                    SQL;
        }

        $device = '';
        $site = '';
        if(isset($params['device'])) {
            $device = <<<SQL
                            AND `d`.`uuid` = :device
                        SQL;
        } else if(isset($params['site'])) {
            $site = <<<SQL
                        AND `e`.`uuid` = :site
                    SQL;
        }

        $qb = $em->createNativeQuery(<<<SQL
                    SELECT
                        `c`.`counter_number`,
                        SUM(`f`.`total_queue`) AS `total_queue`
                    FROM
                        $logTable AS `c`
                    INNER JOIN
                        $deviceTable AS `d`
                            ON `c`.`device_uuid` = `d`.`uuid`
                            AND `d`.`deleted_at` IS NULL
                            $device
                    INNER JOIN
                        $siteTable AS `e`
                            ON `d`.`site_uuid` = `e`.`uuid`
                            AND `e`.`deleted_at` IS NULL
                            $site
                    LEFT JOIN
                        $summaryTable AS `f`
                            ON `c`.`counter_number` = `f`.`counter_number`
                            AND `f`.`deleted_at` IS NULL
                            $date
                    GROUP BY
                        `c`.`counter_number`
                    ORDER BY
                        `c`.`counter_number` ASC
                SQL, $rsm);

        if(isset($params['start_date']) && isset($params['end_date'])) {
            $qb->setParameter('start_date', $params['start_date'])
                ->setParameter('end_date', $params['end_date']);
        }

        if(isset($params['device'])) {
            $qb->setParameter('device', $params['device']);
        } else if(isset($params['site'])) {
            $qb->setParameter('site', $params['site']);
        }

        return $qb;
    }
}
