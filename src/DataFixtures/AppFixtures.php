<?php

namespace App\DataFixtures;

use App\Entity\Remontoire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Montre;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créez un membre
        $member = new Member();
        $member->setNom('Example Name');
        $manager->persist($member);

        // Créez plusieurs remontoires reliés au même membre
        for ($i = 1; $i <= 3; $i++) {
            $remontoire = new Remontoire();
            $remontoire->setId($i);
            $remontoire->setNom('Remontoire ' . $i);
            $remontoire->setMember($member);
            $manager->persist($remontoire);

            // Créez plusieurs montres reliées au même remontoire
            for ($j = 1; $j <= 2; $j++) {
                $montre = new Montre();
                $montre->setBrand('Montre ' . $j);
                $montre->setRemontoireId($remontoire);
                $manager->persist($montre);
            }
        }

        $manager->flush();
    }
}
