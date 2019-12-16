<?php

namespace App\Service;

use App\Entity\EntityInterface;
use App\Repository\JobRepository;
use App\Repository\ServiceRepository;
use App\Repository\ZipcodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Job as JobEntity;

class Job extends AbstractService
{
    protected $repository;

    protected $serviceRepository;

    protected $zipcodeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        JobRepository $repository,
        ServiceRepository $serviceRepository,
        ZipcodeRepository $zipcodeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->serviceRepository = $serviceRepository;
        $this->zipcodeRepository = $zipcodeRepository;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAll(array $params = []): array
    {
        $sql = "SELECT * FROM job WHERE created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        if (!empty($params['service'])) {
            $sql .= ' AND service_id = ' . $params['service'];
        }

        if (!empty($params['zipcode'])) {
            $sql .= ' AND zipcode_id = ' . $params['zipcode'];
        }

        $stmt = $this->entityManager
            ->getConnection()
            ->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function create(EntityInterface $entity): EntityInterface
    {
        $this->basicValidation($entity);
        $this->validateForeignKeys($entity);

        return $this->save($entity);
    }

    /**
     * @param EntityInterface $entity
     * @throws NotFoundHttpException
     * @return EntityInterface
     */
    public function update(EntityInterface $entity): JobEntity
    {
        $this->basicValidation($entity);
        $this->validateForeignKeys($entity);

        /** @var JobEntity $persistedEntity */
        $persistedEntity = $this->find($entity->getId());
        if (is_null($persistedEntity)) {
            throw new NotFoundHttpException(sprintf(
                'The resource \'%s\' was not found.',
                $entity->getId()
            ));
        }

        return $this->save($entity);
    }

    /**
     * @param JobEntity $entity
     */
    private function validateForeignKeys(JobEntity $entity): void
    {
        if (!$this->serviceRepository->find($entity->getServiceId())) {
            throw new BadRequestHttpException(sprintf(
                'Service \'%s\' was not found',
                $entity->getServiceId()
            ));
        }

        if (!$this->zipcodeRepository->find($entity->getZipcodeId())) {
            throw new BadRequestHttpException(sprintf(
                'Zipcode \'%s\' was not found',
                $entity->getZipcodeId()
            ));
        }
    }

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    protected function save(EntityInterface $entity): EntityInterface
    {
        if (is_null($entity->getId())) {
            $this->entityManager->persist($entity);
        } else {
            $this->entityManager->merge($entity);
        }

        $this->entityManager->flush();

        return $entity;
    }
}
