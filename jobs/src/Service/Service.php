<?php

namespace App\Service;

use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class Service extends AbstractService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        ServiceRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }
}
