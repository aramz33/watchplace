<?php

namespace App\Controller;

use App\Entity\Remontoire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemontoireController extends AbstractController
{
    #[Route('/remontoire', name: 'remontoire_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $remontoires = $entityManager->getRepository(Remontoire::class)->findAll();


        return $this->render('remontoire/index.html.twig', [
            'remontoires' => $remontoires,
        ]);

    }

    /**
     * Show a remontoire
     *
     * @param Integer $id (note that the id must be an integer)
     */

    #[Route('/remontoire/{id}', name: 'remontoire_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $remontoire = $entity_manager->getRepository(Remontoire::class)->find($id);

        return $this->render('remontoire/show.html.twig', [
            'remontoire' => $remontoire,
            'url' => $this->generateUrl('remontoire_index')
        ]);
    }
}
