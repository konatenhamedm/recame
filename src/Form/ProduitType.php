<?php

namespace App\Form;

use App\Entity\Categorie;
use \App\Form\ImageType;
use App\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('image', CollectionType::class, [
                'entry_type' => ImageType::class,
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
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'DESC');
                },
                'choice_label' => 'libelle',

            ])
            ->add('description',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
