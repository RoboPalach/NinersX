<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MoodleAdminController extends AbstractController
{
    /**
     * @Route("/moodle/admin", name="admin_moodle")
     */
    public function home(Request $request, CourseRepository $courseRepository, EntityManagerInterface $manager)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $course = $form->getData();
            $manager->persist($course);
            $manager->flush();
        }

        return $this->render('moodle/course_admin.html.twig', [
            'courses' => $courseRepository->findBy([],['position'=>'ASC']),
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/moodle/admin/{slug}", name="admin_moodle_course")
     */
    public function coursePanel(Course $course = null, Request $request, CourseRepository $courseRepository, EntityManagerInterface $manager)
    {
        if(empty($course)){
            throw $this->createNotFoundException('The course does not exist');
        }
        return $this->render('moodle/chapter_admin.html.twig', [
            'course' => $course ,
            'chapters'=>$course->getChapters()
        ]);
    }
}
