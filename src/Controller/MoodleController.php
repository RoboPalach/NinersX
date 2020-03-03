<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Course;
use App\Repository\ChapterRepository;
use App\Repository\CourseRepository;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MoodleController extends AbstractController
{
    /**
     * @Route("/moodle", name="moodle_home")
     */
    public function index(CourseRepository $courseRepository)
    {
        return $this->render('moodle/public_home.html.twig', [
            'courses'=> $courseRepository->findBy([],['position'=>'ASC'])
        ]);
    }

    /**
     * @Route("/moodle/{slug}", name="moodle_course")
     */
    public function coursePage(Course $course){
        return $this->render('moodle/public_course.html.twig',[
            'course'=>$course
        ]);
    }

    /**
     * @Route("/moodle/{courseSlug}/{chapterSlug}", name="moodle_chapter")
     */
    public function chapterPage($courseSlug, $chapterSlug, ChapterRepository $chapterRepository, MarkdownParserInterface $markdownParser){
        $selectedChapter = null;
        $chapters = $chapterRepository->findBy(['slug'=>$chapterSlug]);
        foreach ($chapters as $c){
            if($c->getCourse()->getSlug() == $courseSlug)
                $selectedChapter = $c;
        }
        if(empty($selectedChapter))
            throw new NotFoundHttpException('Kurz nebyl nalezen');

        $html = $markdownParser->transformMarkdown($selectedChapter->getContent());

        return $this->render('moodle/public_chapter.html.twig',[
            'chapter'=>$selectedChapter
        ]);
    }
}
