<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/admin/image", name="admin_image")
     */
    public function admin(Request $request, ImageRepository $imageRepository, EntityManagerInterface $manager)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class,$image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image = $form->getData();
            $image->setOwner($this->getUser());
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('admin_image');
        }
        return $this->render('image/image_admin.html.twig', [
            'images'=>$imageRepository->findBy([],['altName'=>'ASC']),
            'createForm'=>$form->createView()
        ]);
    }
}
