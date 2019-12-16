<?php

namespace Tests\AppBundle\Controller;

use App\DataFixtures\JobFixtures;
use App\DataFixtures\ServiceFixtures;
use App\DataFixtures\ZipcodeFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var KernelBrowser
     */
    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();

        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
    }

    protected function loadServiceFixtures()
    {
        $this->load(new ServiceFixtures());
    }

    protected function loadZipcodeFixtures()
    {
        $this->load(new ZipcodeFixtures());
    }

    protected function loadJobFixtures()
    {
        $this->load(new JobFixtures());
    }

    private function load(Fixture $fixture){
        $fixture->load($this->entityManager);
    }

    public function tearDown()
    {
        parent::tearDown();

        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
}
