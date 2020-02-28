<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Note;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

// Si une table dépend d'une autre table pour être rempli, il faut que la fixture implémente l'interface
//  Doctrine\Common\DataFixtures\DependentFixtureInterface
class NoteFixtures extends BaseFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, "note", function($num){
            $note = (new Note)
                        ->setNote($this->faker->randomNumber(1))
                        ->setAvis($this->faker->realText(30))
                        ->setDateEnregistrement($this->faker->dateTime())
                        ->setUserNoter($this->getRandomReference("membre"))
                        ->setUserNotant($this->getRandomReference("membre"));
            return $note;
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [ UserFixtures::class, UserFixtures::class ];
    }

}
	
