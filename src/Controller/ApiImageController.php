<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiImageController extends AbstractController
{
    /**
     * @Route("/api/image/{id}", name="api_image_remove", methods={"DELETE"})
     */
    public function remove(Image $image=null, EntityManagerInterface $manager)
    {
        if(!empty($image)){
            try{
                $manager->remove($image);
                $manager->flush();
                return new JsonResponse('OK',200);
            } catch (\Exception $e){
                return new JsonResponse($e->getMessage(),$e->getCode());
            }
        }
        else
            return new JsonResponse('Image was not found',404);
    }
}
