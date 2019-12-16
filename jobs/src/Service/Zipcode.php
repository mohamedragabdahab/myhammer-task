<?php

namespace App\Service;

use App\Repository\ZipcodeRepository;
use Doctrine\ORM\EntityManagerInterface;

class Zipcode extends AbstractService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ZipcodeRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }
}
