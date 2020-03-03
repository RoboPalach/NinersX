<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class CourseFixture extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * CourseFixture constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {

        $this->parameterBag = $parameterBag;
    }

    protected function loadData(\Doctrine\Persistence\ObjectManager $manager)
    {
        $this->createMany(5,'courses',function ($i){
            $course = new Course();
            $course->setName($this->faker->company);
            $course->setDescription($this->faker->text(200));
            $course->setOwner($this->getRandomReference('users'));
            $course->setImage($this->getRandomReference('images'));
            $course->setPosition($this->faker->numberBetween(0,5));

            return $course;
        });
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            ImageFixture::class,
            UserFixture::class
        ];
    }
}
