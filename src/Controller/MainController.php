<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home()
    {
        return $this->render('main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/admin", name="app_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin()
    {
        return $this->render('main/administration.html.twig', [
        ]);
    }
    /**
     * @Route("/about", name="app_about")
     */
    public function about()
    {
        return $this->render('main/about_us.html.twig', [
        ]);
    }

}
