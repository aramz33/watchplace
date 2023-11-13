<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Montre;
use App\Entity\Vitrine;
use App\Form\Vitrine1Type;
use App\Repository\VitrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/vitrine')]
class VitrineController extends AbstractController
{
    /*
    #[Route('/', name: 'app_vitrine_index', methods: ['GET'])]
    public function index(VitrineRepository $vitrineRepository): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'vitrines' => $vitrineRepository->findAll(),
        ]);
    }
    */
    #[Route('/member/{id}/vitrine', name: 'app_vitrine_index',requirements: ['id' => '\d+'] ,methods: ['GET'])]
    public function vitrine(VitrineRepository $vitrineRepository, ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Member::class)->find($id);

        return $this->render('vitrine/index.html.twig', [
            'member' => $member,
            'vitrines' => $vitrineRepository->findBy(['published' => true]),
        ]);
    }


    #[Route('/new/{id}', name: 'app_vitrine_new',  requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request,EntityManagerInterface $entityManager, VitrineRepository $vitrineRepository, Member $member): Response
    {
        $vitrine = new Vitrine();
        $vitrine->setCreator($member);
        $form = $this->createForm(Vitrine1Type::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vitrine);
            $entityManager->flush();

            return $this->redirectToRoute('member_index', ['id' => $member->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine/new.html.twig', [
            'member' => $member,
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    #[Route('/member/{id}/show', name: 'app_vitrine_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Vitrine $vitrine, ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Vitrine::class)->find($id);
        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $vitrine->isPublished()) {
            $hasAccess = true;
        }
        else {
            $user = $this->getUser();
            if( $user ) {
                $member = $user->getMember();
                if ( $member &&  ($member == $vitrine->getCreator()) ) {
                    $hasAccess = true;
                }
            }
        }
        if(! $hasAccess) {
            throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }

        return $this->render('vitrine/show.html.twig', [

            'vitrine' => $vitrine,
            'url' => $this->generateUrl('app_my_vitrines', ['id' => $member->getId()]),
            'member' => $member,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_vitrine_edit', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Vitrine $vitrine, EntityManagerInterface $entityManager, Member $member): Response
    {
        $form = $this->createForm(Vitrine1Type::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vitrine_index', ['id' => $member->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine/edit.html.twig', [
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    #[Route('/delete/vitrine/{id}', name: 'app_vitrine_delete',requirements: ['id' => '\d+'], methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, Vitrine $vitrine, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Member::class)->find($id);

        if ($this->isCsrfTokenValid('delete'.$vitrine->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vitrine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_my_vitrines', ['id' => $id, 'vitrine' => $vitrine, 'member'=>$member], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{vitrine_id}/montre/{montre_id}', methods: ['GET'], name: 'app_vitrine_montre_show')]
    public function MontreShow( #[MapEntity(id: 'vitrine_id')] Vitrine $vitrine,
       #[MapEntity(id: 'montre_id')]
       Montre $montre ): Response
   {
       if(! $vitrine->getMontres()->contains($montre)) {
           throw $this->createNotFoundException("Montre introuvable dans cette vitrine!");
       }

       $hasAccess = false;
       if($this->isGranted('ROLE_ADMIN') || $vitrine->isPublished()) {
           $hasAccess = true;
       }
       else {
           $user = $this->getUser();
           if( $user ) {
               $member = $user->getMember();
               if ( $member &&  ($member == $vitrine->getCreator()) ) {
                   $hasAccess = true;
               }
           }
       }
       if(! $hasAccess) {
           throw $this->createAccessDeniedException("You cannot access the requested ressource!");
       }

       return $this->render('vitrine/montre_show.html.twig', [
           'montre' => $montre,
           'vitrine' => $vitrine,
           'url' => $this->generateUrl('app_vitrine_index', ['id' => $vitrine->getCreator()->getId()]),
       ]);
   }

    #[Route('/member/{id}/my_vitrines', name: 'app_my_vitrines', requirements: ['id' => '\d+'], methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function myVitrines(VitrineRepository $vitrineRepository, ManagerRegistry $doctrine,  $id): Response
    {
        $user = $this->getUser();
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Member::class)->find($id);

        if (!$user || $user->getMember()->getId() != $id) {
            throw $this->createAccessDeniedException('Access Denied.');
        }

        $vitrines = $vitrineRepository->findBy(['creator' => $user->getMember()]);

        return $this->render('vitrine/my_vitrines.html.twig', [
            'vitrines' => $vitrines,
            'member' => $member,
        ]);
    }


}
