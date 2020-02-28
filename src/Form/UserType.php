<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Contrainte;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class, [ "help" => "Tapez votre pseudo",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 3, "max" => 20,
                                         "minMessage" => "Le pseudo doit contenir au moins 3 caractères",
                                         "maxMessage" => "Le pseudo ne doit pas dépasser 20 caractères"])
                             ]])
            ->add('nom', TextType::class, [ "help" => "Tapez votre nom",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 1, "max" => 40,
                                         "minMessage" => "",
                                         "maxMessage" => "Le nom ne doit pas dépasser 40 caractères"])
                             ]])
            ->add('prenom', TextType::class, [ "help" => "Tapez votre prénom",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 1, "max" => 40,
                                         "minMessage" => "Le prénom doit contenir au moins 1 caractères",
                                         "maxMessage" => "Le prénom ne doit pas dépasser 40 caractères"])
                             ]])
            ->add('email', EmailType::class, [ "help" => "Tapez votre email",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 3, "max" => 50,
                                         "minMessage" => "L'email' doit contenir au moins 3 caractères",
                                         "maxMessage" => "L'email' ne doit pas dépasser 50 caractères"])
                             ]])
            ->add('roles', ChoiceType::class,[
                "label" => "Statut",
                "choices" => [
                    "User" => "ROLE_USER",
                    "Administrateur" => "ROLE_ADMIN"
                ]
            ])
            ->add('password', PasswordType::class, [ "help" => "Tapez votre mot de passe",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 5, "max" => 40,
                                         "minMessage" => "Le mot de passe doit contenir au moins 5 caractères",
                                         "maxMessage" => "Le mot de passe ne doit pas dépasser 40 caractères"])
                             ]])
            ->add('telephone', TextType::class, [ "help" => "Tapez votre numéro de téléphone",
            "data" => "",
            "constraints" => [ 
                             new Contrainte\NotBlank(["message" => "Vous avez oublié de remplir ce champ"]),
                             new Contrainte\Length(["min" => 10, "max" => 10,
                                         "minMessage" => "Le numéro de téléphone doit contenir 10 chiffres",
                                         "maxMessage" => "Le numéro de téléphone doit contenir 10 chiffres"])
                             ]])
            ->add('civilite', ChoiceType::class,[
                "choices" => [
                    "Homme" => "h",
                    "Femme" => "f",
                    "Autre" => "a"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
