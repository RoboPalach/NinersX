<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiShopController extends AbstractController
{
    /**
     * @Route("/api/shop", name="api_shop")
     */
    public function index()
    {
        return $this->render('api_shop/index.html.twig', [
            'controller_name' => 'ApiShopController',
        ]);
    }
}
