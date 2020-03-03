<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Course;
use App\Repository\ChapterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    /**
     * @Route("/api/moodle/{id}/chapter/", methods={"POST"}, name="api_moodle_chapter_add")
     */
    public function addChapter(Course $course=null,Request $request, EntityManagerInterface $manager, SerializerInterface $serializer){
        if(empty($course))
            return new JsonResponse('Course wasnt found', 404);
        $r = $request->request->all();
        $chapter = new Chapter();
        $chapter->setName($r['name']);
        $chapter->setPosition((int)$r['position']);
        $chapter->setContent($r['content']);
        $chapter->setOwner($this->getUser());
        $chapter->setCourse($course);
        $manager->persist($chapter);
        $manager->flush();
        $response = [
            'id'=>$chapter->getId(),
            'createdAt'=> $chapter->getCreatedAt(),
            'author'=>$chapter->getOwner()->__toString()
        ];

        return new JsonResponse($response,200);
    }
    /**
     * @Route("/api/moodle/{id}/chapter/", methods={"PUT"}, name="api_moodle_chapter_update")
     */
    public function updateChapter(Course $course = null, Request $request, ChapterRepository $chapterRepository, EntityManagerInterface $manager){
        if(empty($course))
            return new JsonResponse('Course wasnt found',404);
        $r = $request->request->all();
        if(!(array_key_exists('id',$r)&&is_numeric($r['id'])))
            return new JsonResponse('Invalid request data format',500);
        $chapter = $chapterRepository->findOneBy(['id'=>$r['id']]);
        if(empty($chapter))
            return new JsonResponse('Chapter wasnt found',404);
        $chapter->setName($r['name']);
        $chapter->setPosition((int)$r['position']);
        $chapter->setContent($r['content']);
        $manager->flush();

        $response = [
            'id'=>$chapter->getId(),
            'createdAt'=> $chapter->getCreatedAt(),
            'author'=>$chapter->getOwner()->__toString(),
            'content'=>$chapter->getContent(),
            'r'=>$r
        ];
        return new JsonResponse($response,200);

    }


}
