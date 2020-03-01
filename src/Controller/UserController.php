<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profile/{slug}", name="user_profile")
     */
    public function profile($slug="none", UserRepository $userRepository)
    {
        if($slug!="none")
            $user = $userRepository->findOneBy(['slug'=>$slug]);
        else
            $user = $this->getUser();

        if(!$user)
            throw new \Exception("User with this slug doesn't exist",404);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/points", name="admin_points")
     */
    public function listUser(UserRepository $userRepository, TeamRepository $teamRepository){
        return $this->render("user/list.html.twig",[
            'users'=>$userRepository->findBy([],['surname'=>'ASC']),
            'teams'=>$teamRepository->findBy([],['name'=>"ASC"])
        ]);
    }
}
