<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Commentaire;

class CommentaireFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager){
        $this->createMany(60, "comment", function($num){
            $commentaire = (new Commentaire)
                       ->setUser($this->getRandomReference("membre"))
                        ->setAnnonce($this->getRandomReference("anno"))
                        ->setCommentaire($this->faker->realText(100))
                        ->setDateEnregistrement($this->faker->dateTime());
                        
            return $commentaire;
        });

         $manager->flush();
    }

    public function getDependencies(){
         return [ UserFixtures::class, AnnonceFixtures::class ];
    }

    
}
