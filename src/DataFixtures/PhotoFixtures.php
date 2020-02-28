<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Photo;


class PhotoFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(1000, "photo", function($num){
            $photo = (new Photo)
                        ->setPhoto1($this->faker->numberBetween($min=1, $max= 5) . ".jpg");
                        
            return $photo;
        });

        $manager->flush();
    }

    
    
}
