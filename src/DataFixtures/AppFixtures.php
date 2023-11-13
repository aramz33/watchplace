<?php

namespace App\DataFixtures;

use App\Entity\Remontoire;
use App\Entity\User;
use App\Entity\Vitrine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Montre;
use App\Entity\Member;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {

        $members = $manager->getRepository(Member::class)->findAll();

        foreach ($members as $member) {
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
        }


        $manager->flush();
    }
}
