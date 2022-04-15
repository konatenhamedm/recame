<?php

namespace App\Form;

use App\Entity\Image;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', FileType::class, array(
                'label' => 'insert image', "label" => false,
                'required' => false,
                'data_class' => null,
                'mapped' => false,
            ))
            ->add('titre', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ["label" => false,])
            ->add('description', TextareaType::class, ["label" => false,]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
