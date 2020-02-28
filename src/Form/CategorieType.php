<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Contrainte;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ["help" => "Entrez le titre de la catégorie", 
                                            "data" => "categorie", "constraints" => [ 
                                                                                    new Contrainte\NotBlank(["message" => "vous avez oublié de remplir le champ"]),
                                                                                    new Contrainte\Length([ "min" => 2, 
                                                                                                            "max" => 20, 
                                                                                                            "minMessage" => "Le titre doit avoir au moins 2 caracteres",
                                                                                                            "maxMessage" => "le titre ne doit pas depasser 20 caracteres"]) ]   ])

            ->add('motscles', TextareaType::class, [ "label" => "Mots clés", "help"=> "separer les mots clés par des ', '"])

            // ->add("Ajouter", SubmitType::class, ["label" => "Enregistrer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
