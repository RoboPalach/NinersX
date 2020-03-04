<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Json;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/user/{id}/changePoints", name="api_user_change_points")
     */
    public function changePoint(User $user, Request $request, EntityManagerInterface $manager)
    {
        if($user){
            $points = (int)$request->request->get('points');
            $user->changeKarma($points);
            $manager->flush($user);
            return new JsonResponse(['id'=>$user->getId(), "points"=>$user->getKarma()],200);
        }

        return new JsonResponse("Something bad happens. Because dev was lazy and under pressure he wasnt make proper error message",500);
    }

    /**
     * @Route("/api/user/{id}", methods={"put"}, name="api_user_update")
     */
    public function updateUser(User $user = null, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager){
        if(empty($user))
            return new JsonResponse('User not found',404);
        if($user->getId()!=$this->getUser()->getId())
            return new JsonResponse('You cant change another user',403);
        $user->setName($request->request->get('name'));
        $user->setSurname($request->request->get('surname'));
        $password = $request->request->get('password');
        if(!empty($password)){
            $user->setPassword($encoder->encodePassword($user, $password));
        }
        $manager->flush();
        return new JsonResponse('OK');


    }
}
