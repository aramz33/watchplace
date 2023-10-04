<?php

namespace App\Controller;

use App\Entity\Montre;
use App\Entity\Remontoire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MontreController extends AbstractController
{
    #[Route('/montre', name: 'app_montre')]
    public function index(): Response
    {
        return $this->render('montre/index.html.twig', [
            'controller_name' => 'MontreController',
        ]);
    }
    #[Route('/montre/{id}', name: 'montre_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $montre = $entity_manager->getRepository(Montre::class)->find($id);

        return $this->render('montre/show.html.twig', [
            'montre' => $montre,
        ]);
    }
}
