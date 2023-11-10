<?php

namespace App\DataFixtures;

use App\Entity\Remontoire;
use App\Entity\Vitrine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Montre;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

            $member = new Member();
            $member->setNom('Test Member');
            $manager->persist($member);

            // Création de plusieurs remontoires pour le membre
            for ($i = 1; $i <= 3; $i++) {
                $remontoire = new Remontoire();
                $remontoire->setNom('Remontoire - ' . $i);
                $remontoire->setMember($member);

                // Création de plusieurs montres pour chaque remontoire
                for ($j = 1; $j <= 2; $j++) {
                    $montre = new Montre();
                    $montre->setBrand('Marque - ' . $j);
                    $montre->setRemontoireId($remontoire);
                    $manager->persist($montre);
                }

                $manager->persist($remontoire);
            }
            // Création de plusieurs vitrines pour le membre
            for ($v = 1; $v <= 2; $v++) {
                $vitrine = new Vitrine();
                $vitrine->setDescription('Vitrine ' . $v);
                $vitrine->setPublished(true);
                $vitrine->setCreator($member);
                $manager->persist($vitrine);
            }

        $manager->flush();
    }
}
