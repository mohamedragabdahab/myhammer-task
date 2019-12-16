<?php

namespace App\Repository;

use App\Entity\Zipcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Zipcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zipcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zipcode[]    findAll()
 * @method Zipcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZipcodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zipcode::class);
    }
}