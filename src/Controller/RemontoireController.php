<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Remontoire;
use App\Entity\Vitrine;
use App\Form\RemontoireType;
use App\Form\Vitrine1Type;
use App\Repository\RemontoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RemontoireController extends AbstractController
{
    //#[Route('/remontoire', name: 'remontoire_index')]
    /*public function index(ManagerRegistry $doctrine): Response
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

    #[Route('member/{member_id}/remontoire/{remontoire_id}', name: 'remontoire_show', requirements: ['member_id' => '\d+', 'remontoire_id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(ManagerRegistry $doctrine, $member_id, $remontoire_id): Response
    {

        $entity_manager = $doctrine->getManager();
        $remontoire = $entity_manager->getRepository(Remontoire::class)->find($remontoire_id);
        $member= $remontoire->getMember();
        $hasAccess = $this->isGranted('ROLE_ADMIN') ||
            ($this->getUser()->getMember() == $remontoire->getMember());
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("Tu n'as pas l'accès au remontoires des autres !! Logique");
        }

        return $this->render('remontoire/show.html.twig', [
            'remontoire' => $remontoire,
            'url' => $this->generateUrl('member_show', ['id' => $member->getId()]),
        ]);
    }

    #[Route('/new/{id}', name: 'app_remontoire_new', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request,EntityManagerInterface $entityManager, RemontoireRepository $remontoireRepository, Member $member): Response
    {
        $remontoire = new Remontoire();
        $remontoire->setMember($member);
        $form = $this->createForm(RemontoireType::class, $remontoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($remontoire);
            $entityManager->flush();

            return $this->redirectToRoute('member_show', ['id' => $member->getId()], Response::HTTP_SEE_OTHER);
        }


        return $this->render('remontoire/new.html.twig', [
            'member' => $member,
            'remontoire' => $remontoire,
            'form' => $form,

        ]);
    }
}
