<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\Base;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture implements DependentFixtureInterface
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
            $user->setEmail(sprintf("user%02d@niners.cz",$i));
            $user->setBio($this->faker->text(250));
            for($i=0; $i<$this->faker->numberBetween(1,3);$i++){
                $user->addTeam($this->getRandomReference('teams'));
            }
            $user->setPassword($this->passwordEncoder->encodePassword($user,"engage"));
            $user->changeKarma($this->faker->numberBetween(-5,350));

            return $user;
        });
        $user = new User();
        $user->setName("Pavel");
        $user->setSurname("Šrytr");
        $user->setEmail("pajasry@gmail.com");
        for($i=0; $i<$this->faker->numberBetween(1,3);$i++){
            $user->addTeam($this->getRandomReference('teams'));
        }
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setBio($this->faker->text(250));
        $user->setPassword($this->passwordEncoder->encodePassword($user,"engage"));
        $user->changeKarma($this->faker->numberBetween(350,1000));
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            TeamFixture::class
        ];
    }
}
