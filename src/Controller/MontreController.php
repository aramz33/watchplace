<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Montre;
use App\Entity\Remontoire;
use App\Form\MontreType;
use App\Form\RemontoireType;
use App\Repository\MontreRepository;
use App\Repository\RemontoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MontreController extends AbstractController
{

    #[Route('/montre/{id}', name: 'montre_show', requirements: ['id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $montre = $entity_manager->getRepository(Montre::class)->find($id);

        return $this->render('montre/show.html.twig', [
            'montre' => $montre,
            'url' => $this->generateUrl('remontoire_show', ['remontoire_id' => $montre->getRemontoireId()->getId(), 'member_id' => $montre->getRemontoireId()->getMember()->getId()]),
        ]);
    }

    #[Route('montre/new/{id}', name: 'montre_new', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request,EntityManagerInterface $entityManager, MontreRepository $montreRepository, Remontoire $remontoire): Response
    {
        $montre = new Montre();
        $montre->setRemontoireId($remontoire);
        $form = $this->createForm(MontreType::class, $montre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($montre);
            $entityManager->flush();

            return $this->redirectToRoute('remontoire_show', ['remontoire_id' => $remontoire->getId(), 'member_id' => $remontoire->getMember()->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('montre/new.html.twig', [
            'remontoire' => $remontoire,
            'montre' => $montre,
            'form' => $form,

        ]);
    }
}
