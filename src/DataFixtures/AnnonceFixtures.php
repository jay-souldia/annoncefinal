<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Annonce;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager){

        $this->createMany(10, "anno", function($num){
            $annonce = (new Annonce)
                        ->setPrix($this->faker->randomNumber(5))
                        ->setTitre($this->faker->realText(10))
                        ->setDescriptioncourte($this->faker->sentences($nb = 1, $variableNbSentences = true) )
                        ->setDescriptionlongue($this->faker->paragraph($nbSentences = 5, $variableNbSentences = true))
                        ->setAdresse($this->faker->streetAddress)
                        ->setVille($this->faker->city)
                        ->setCp($this->faker->randomNumber($nbDigits = 5, $strict = true))
                        ->setPays($this->faker->country)
                        ->setDateEnregistrement($this->faker->dateTime())
                        ->setUser($this->getRandomReference("membre"))
                        ->setPhoto($this->getRandomReference("photo"))
                        ->setCategorie($this->getRandomReference("cat"));
            return $annonce;
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [ UserFixtures::class, PhotoFixtures::class, CategorieFixtures::class ];
    }
    
    
}
