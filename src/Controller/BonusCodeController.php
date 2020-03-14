<?php

namespace App\Controller;

use App\Entity\BonusCode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BonusCodeController extends AbstractController
{

    /**
     * @Route("/bonusCode/{code}/collect", name = "bonus_code_collect")
     * @IsGranted("ROLE_USER")
     */
    public function collectBonudCode(BonusCode $bonusCode = null, EntityManagerInterface $manager){
        if(empty($bonusCode))
            return new JsonResponse("Takový kód bohužel neexistuje.");
        if(!$bonusCode->isActive())
            return new JsonResponse("Tento kód není aktivní. Jsi tu pozdě nebo brzo.");
        $bonusCode->getAward($this->getUser());
        $manager->flush();
        return $this->render('bonus_code/awarded.html.twig',[
            'code'=>$bonusCode
        ]);
    }

}
