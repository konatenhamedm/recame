<?php

namespace App\Form;

use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('prix')
            ->add('image', FileType::class, array(
                'label' => 'insert image',
                'required' => false,
                'data_class' => null,
                'mapped' => true,
            ))
            ->add('images', CollectionType::class, [
                'entry_type' => ImagesType::class,
                'entry_options' => [
                    'label' => false
                ],
                'attr' => [
                    'class' => 'col-md-12'
                ],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => [
                    'class' => 'collection',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
