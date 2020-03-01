<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\Base;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(\Doctrine\Persistence\ObjectManager $manager)
    {
        $this->createMany(20, 'users', function ($i){
            $user = new User();
            $user->setName($this->faker->firstName());
            $user->setSurname($this->faker->lastName);
            $user->setEmail(sprintf("user%03d@niners.cz",$i));
            $user->setPassword($this->passwordEncoder->encodePassword($user,"engage"));
            $user->changeKarma($this->faker->numberBetween(-5,350));

            return $user;
        });

        $manager->flush();
    }
}
