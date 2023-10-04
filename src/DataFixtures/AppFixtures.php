<?php

namespace App\DataFixtures;

use App\Entity\Remontoire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Montre;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $remontoire = new Remontoire();
        $remontoire->setId(1);

        $manager->persist($remontoire);

        $montre = new Montre();
        $montre->setBrand('Example Brand');
        $montre->setRemontoireId($remontoire);

        $manager->persist($montre);


        $manager->flush();
    }
}
