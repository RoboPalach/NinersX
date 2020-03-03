<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

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

    /**
     * @Route("/api/image", name="api_image_list",methods={"GET"})
     */
    public function list(ImageRepository $imageRepository, UploaderHelper $helper){
        global $hlp;
        $GLOBALS['hlp']=$helper;
        /**
         * @var $i Image
         */
        $res = array_map(function ($i){
          return [
              "id"=>$i->getId(),
              "name"=>$i->getAltName(),
              "url"=> $GLOBALS['hlp']->asset($i,'imageFile'),
              "owner"=>[
                  "name"=>$i->getOwner()->__toString(),
                  "slug"=>$i->getOwner()->getSlug()
              ],
              "createdAt"=>$i->getCreatedAt()->format("d/m/yy H:i:s")
              ];
        },
            $imageRepository->findAll()
        );
        return new JsonResponse($res);

    }
}
