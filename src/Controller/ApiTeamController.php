<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiTeamController extends AbstractController
{
    /**
     * @Route("/api/team/{id}/changePoints", name="api_team_change_point")
     */
    public function changePoints(Team $team,Request $request, EntityManagerInterface $manager)
    {
        if($team){
            $points = (int)$request->request->get('points');
            foreach ($team->getMembers() as $u){
                $u->changeKarma($points);
            }
            $manager->flush();
            return new JsonResponse('Karma of all team member was updated',200);
        }
        return new JsonResponse("Something bad happens. Because dev was lazy and under pressure he wasnt make proper error message",500);
    }

}
