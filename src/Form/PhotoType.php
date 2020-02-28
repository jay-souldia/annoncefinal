<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Input;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo1', Input\FileType::class, [
                'label' => '1ere photo',
                'required' => true,
            ])
            ->add('photo2', Input\FileType::class, [
                'label' => '2eme photo',
                'required' => false,
            ])
            ->add('photo3', Input\FileType::class, [
                'label' => '3eme photo',
                'required' => false,
            ])
            ->add('photo4', Input\FileType::class, [
                'label' => '4eme photo',
                'required' => false,
            ])
            ->add('photo5', Input\FileType::class, [
                'label' => '5eme photo',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
