<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiMoodleController extends AbstractController
{
    /**
     * @Route("/api/moodle/{id}", methods={"DELETE"}, name="api_moodle_course_remove")
     */
    public function removeCourse(Course $course = null, EntityManagerInterface $manager)
    {
        if(!empty($course)){
            try{
                $manager->remove($course);
                $manager->flush();
                return new JsonResponse('Course was removed',200);
            } catch(\Exception $e){
                return new JsonResponse($e->getMessage(), $e->getCode());
            }
        }
        else
            return new JsonResponse('Course wasnt found',404);
    }

    /**
     * @Route("/api/moodle/chapter/{id}", methods={"DELETE"}, name="api_moodle_chapter_remove")
     */
    public function removeChapter(Chapter $chapter = null, EntityManagerInterface $manager)
    {
        if(!empty($chapter)){
            try{
                $manager->remove($chapter);
                $manager->flush();
                return new JsonResponse('Chapter was removed',200);
            } catch(\Exception $e){
                return new JsonResponse("Something bad happend. Becouse developer was lazy he wasnt write proper error log",500);
            }
        }
        else
            return new JsonResponse('Chapter wasnt found',404);
    }


}
