<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TeamFixture extends BaseFixture
{
    protected function loadData(\Doctrine\Persistence\ObjectManager $manager)
    {
        $this->createMany(5,'teams',function($i){
            $team = new Team();
            $team->setName($this->faker->country);
            $team->setColor($this->faker->rgbColor);
            return $team;
        });
        $manager->flush();
    }
}
