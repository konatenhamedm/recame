<?php

namespace App\Form;

use App\Entity\CodeDepartement;
use App\Entity\Departement;
use App\Entity\Localite;
use App\Entity\Profession;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libDepartement')
            ->add('etat',ChoiceType::class,
                [
                    'expanded'     => false,
                    'placeholder' => 'Choisir un etat',
                    'required'     => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices'  => array_flip([
                        'OK'        => 'OK',
                        'NON'       => 'NON',

                    ]),
                ])
            ->add('dateCreation',DateType::Class, [
                "required" => false,
                "widget" => 'single_text',
                "input_format"=>'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
                'label'=>"Date creation",
            ])
            ->add('region', EntityType::class, [
                'class' => Localite::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'choice_label' => 'libelle',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departement::class,
        ]);
    }
}
