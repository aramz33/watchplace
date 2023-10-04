<?php

namespace App\Controller;

use App\Entity\Remontoire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemontoireController extends AbstractController
{
    #[Route('/remontoire', name: 'app_remontoire')]
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
    public function show(ManagerRegistry $doctrine, $id)
    {
        $remontoireRepo = $doctrine->getRepository(Remontoire::class);
        $remontoire = $remontoireRepo->find($id);

        if (!$remontoire) {
            throw $this->createNotFoundException('The remontoire does not exist');
        }

        $res = '<h1>Details du Remontoire</h1>';
        $res .= '<ul>';
        $res .= '<li>ID: ' . $remontoire->getId() . '</li>';
        $res .= '<li>Nom: ' . $remontoire->getNom() . '</li>';
        $res .= '<li>Membre: ' . $remontoire->getMember()->getNom() . '</li>';
        $res .= '</ul>';

        $res .= '<p><a href="' . $this->generateUrl('remontoire_index') . '">Retour</a></p>';

        return new Response('<lang html><body>'. $res . '</body></langhtml>');
}

}
