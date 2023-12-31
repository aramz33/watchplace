<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Entity\Remontoire;
use App\Entity\Vitrine;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Montre;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractDashboardController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(RemontoireCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        $dashboard = Dashboard::new()
            ->setTitle('Watchplace');
        return $dashboard;
    }

    public function configureMenuItems(): iterable
    {
        $user = $this->security->getUser();
        if ($user && $user->getMember()) {
            $memberId = $user->getMember()->getId();
            $memberIndexUrl = $this->container->get(AdminUrlGenerator::class)
                ->setRoute('member_show', ['id' => $memberId])
                ->generateUrl();

            yield MenuItem::linkToUrl('Watchplace', 'fa fa-home', $memberIndexUrl);
        }
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tes Remontoires', 'fas fa-list', Remontoire::class);
        yield MenuItem::linkToCrud('Tes Montres', 'fas fa-list', Montre::class);
        yield MenuItem::linkToCrud('Tes Membres', 'fas fa-list', Member::class);
        yield MenuItem::linkToCrud('Tes Vitrines', 'fas fa-list', Vitrine::class);

    }
}
