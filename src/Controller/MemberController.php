<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\VitrineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'member_index')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $user = $this->getUser();
        if (!$user || !$user->getMember()) {
            // Optionally, you can throw an exception or redirect the user
            throw $this->createNotFoundException('Member not found.');
        }

        $member = $doctrine->getManager()->getRepository(Member::class)->find($user->getMember()->getId());



        return $this->render('member/index.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/member/{id}', name: 'member_show', requirements: ['id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Member::class)->find($id);



        return $this->render('member/show.html.twig', [
            'member' => $member,
            'url' => $this->generateUrl('member_index' , ['id' => $member->getId()]),
        ]);

    }

}
