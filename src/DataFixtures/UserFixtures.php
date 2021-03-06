<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, "admin", function($num){
            //Création d'un utilisateur Admin
            $email = "admin" . $num . "@annonceosy.com";
            $userAdmin = (new User)
                            ->setNom($this->faker->lastName)
                            ->setPrenom($this->faker->firstName)
                            ->setEmail($email)
                            ->setPassword(password_hash("admin" . $num, PASSWORD_DEFAULT))
                            ->setRoles(["ROLE_ADMIN"])
                            ->setCivilite($this->faker->randomElement(["H", "F", "A"]))
                            ->setPseudo("admin$num")
                            ->setTelephone($this->faker->e164PhoneNumber)
                            ->setDateEnregistrement($this->faker->dateTime());
            return $userAdmin;
        });

        $this->createMany(100, "membre", function($num){
            //Création d'un utilisateur 
            $email = "user" . $num . "@yopmail.com";
            $user = (new User)
                        ->setNom($this->faker->lastName)
                        ->setPrenom($this->faker->firstName)
                        ->setEmail($email)
                        ->setRoles(["ROLE_USER"])
                        ->setPassword(password_hash("user" . $num, PASSWORD_DEFAULT))
                        ->setCivilite($this->faker->randomElement(["H", "F", "A"]))
                        ->setPseudo("user$num")
                        ->setTelephone($this->faker->e164PhoneNumber)
                        ->setDateEnregistrement($this->faker->dateTime());
            return $user;
        });
        $manager->flush();
    }

}
