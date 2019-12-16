<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data() as $item) {
            $service = new Service($item[0], $item[1]);
            $manager->persist($service);
            $manager->flush();
        }
    }

    private function data(): array
    {
        return [
            [804040, 'Sonstige Umzugsleistungen'],
            [802030, 'Abtransport, Entsorgung und Entrümpelung'],
            [411070, 'Fensterreinigung'],
            [402020, 'Holzdielen schleifen'],
            [108140, 'Kellersanierung']
        ];
    }
}