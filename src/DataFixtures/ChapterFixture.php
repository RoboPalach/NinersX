<?php

namespace App\DataFixtures;

use App\Entity\Chapter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ChapterFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(\Doctrine\Persistence\ObjectManager $manager)
    {
        $this->createMany(25,'chapters',function($i){
            $chapter = new Chapter();
            $chapter->setName($this->faker->text(15));
            $chapter->setPosition($this->faker->numberBetween(-1,10));
            $chapter->setContent("## Hello word");
            $chapter->setOwner($this->getRandomReference('users'));
            $chapter->setCourse($this->getRandomReference('courses'));

            return $chapter;
        });
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            CourseFixture::class,
            UserFixture::class
        ];
    }
}
