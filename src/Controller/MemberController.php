<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\VitrineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'member_index')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();

        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/member/{id}', name: 'member_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $entity_manager = $doctrine->getManager();
        $member = $entity_manager->getRepository(Member::class)->find($id);

        return $this->render('member/show.html.twig', [
            'member' => $member,
            'url' => $this->generateUrl('member_show' , ['id' => $member->getId()]),
        ]);

    }

}
