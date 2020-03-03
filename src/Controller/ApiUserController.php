<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
}
