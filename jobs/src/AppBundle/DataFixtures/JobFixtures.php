<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;

class JobFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $job = new Job(
            804040,
            '10115',
            'title',
            'decription',
            new DateTime('2018-11-11'),
            'a961c741-1c32-11ea-bfc6-0242ac130003'
        );

        $this->setIdExplicitly($manager, $job);

        $manager->persist($job);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ServiceFixtures::class,
            ZipcodeFixtures::class
        ];
    }

    private function setIdExplicitly(ObjectManager $manager, Job $entity)
    {
        $metadata = $manager->getClassMetaData(get_class($entity));
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }
}
