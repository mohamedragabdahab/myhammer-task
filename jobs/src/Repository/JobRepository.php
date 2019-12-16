<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function findAllForLastMonthByServiceAndZipcode(array $params)
    {

        $queryBuilder = $this->createQueryBuilder('job');

        $startDate = (new \DateTime())->sub(new \DateInterval('P30D'));
        $endDate = new \DateTime();

        $queryBuilder = $queryBuilder->where('job.created_at BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate);


        if (!empty($params['service'])) {
            $queryBuilder = $queryBuilder->andWhere('job.service_id = :serviceId');
            $queryBuilder = $queryBuilder->setParameter('searchTerm', $params['service']);
        }

        if (!empty($params['service'])) {
            $queryBuilder = $queryBuilder->andWhere('job.zipcode_id = :zipcodeId');
            $queryBuilder = $queryBuilder->setParameter('enabled', $params['zipcode']);
        }

        return $queryBuilder
            ->getQuery()
            ->execute();

    }
}
