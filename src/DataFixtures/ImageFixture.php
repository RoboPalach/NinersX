<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class ImageFixture extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;
    private $images;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CourseFixture constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag, LoggerInterface $logger)
    {

        $this->parameterBag = $parameterBag;
        $this->images =new \ArrayObject(array());
        $this->logger = $logger;
    }

    protected function loadData(\Doctrine\Persistence\ObjectManager $manager)
    {
        /*$files = glob($this->parameterBag->get('kernel.project_dir').'/public/imagesRepository/*'); // get all file names
        $this->logger->info('Clearing '.$this->parameterBag->get('kernel.project_dir').'/public/imagesRepository');
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
        $this->logger->info('Image repository was cleared');

        $this->logger->info('Creating random images');
        for ($i=0;$i<2;$i++){
            $this->images->append($this->faker->image($this->parameterBag->get('kernel.project_dir').'/public/imagesRepository'));
            $this->logger->info($i.'. image was created - '.$this->images[sizeof($this->images)-1]);
        }
        $this->logger->info('Creating entities');*/
        $this->createMany(3,'images',function ($i){
            $image = new Image();
            $image->setAltName($this->faker->streetName);
            $image->setOwner($this->getRandomReference('users'));
            //$this->logger->info('Image '. $this->images[1]);
            $image->setName('test.jpg');
            return $image;
        });
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            UserFixture::class
        ];
    }
}
