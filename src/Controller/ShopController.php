<?php

namespace App\Controller;

use App\Entity\ShopItem;
use App\Repository\ShopItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop_home")
     */
    public function index(ShopItemRepository $repository)
    {
        return $this->render('shop/index.html.twig', [
            'items' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/shop/{id}", name="shop_item")
     */
    public function item(ShopItem $item = null){
        if(empty($item))
            return $this->createNotFoundException('Item not found');
        return $this->render('shop/item.html.twig',[
            'item'=>$item
        ]);
    }
}
