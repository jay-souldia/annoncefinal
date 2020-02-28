<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Categorie;

class CategorieFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager){

        $this->createMany(80, "cat", function($num){
            $categorie = (new Categorie)
                        ->setTitre($this->faker->word)
                        ->setMotscles($this->faker->words($nb = 3, $asText = true));
                        
            return $categorie;
        });

        $manager->flush();
    }

    // public function getDependencies(){
    //     return [ UserFixtures::class, UserFixtures::class ];
    // }
    
}
