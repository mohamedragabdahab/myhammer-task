<?php

namespace App\DataFixtures;

use App\Entity\Zipcode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ZipcodeFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data() as $item) {
            $zipcode = new Zipcode($item[0], $item[1]);
            $manager->persist($zipcode);
            $manager->flush();
        }
    }

    private function data(): array
    {
        return [
            ['10115', 'Berlin'],
            ['32457', 'Porta Westfalica'],
            ['01623', 'Lommatzsch'],
            ['21521', 'Hamburg'],
            ['06895', 'Bülzig'],
            ['01612', 'Diesbar-Seußlitz']
        ];
    }
}