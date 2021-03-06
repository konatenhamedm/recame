<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Localite;
use App\Entity\Membre;
use App\Entity\Profession;
use App\Repository\DepartementRepository;
use App\Repository\LocaliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;

class MembreType extends AbstractType
{

    private $departementRepository;

    public function __construct(DepartementRepository $departementRepository)
    {
        $this->departementRepository = $departementRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event)
             {
                 //$departement = $event->getData()['departement'] ?? null;

                 $departement = $this->departementRepository->createQueryBuilder('d')
                     ->andWhere('d.region =:localite')
                     ->setParameter('localite',1)
                     ->orderBy('d.libDepartement','ASC')
                     ->getQuery()
                     ->getResult();
                 $event->getForm()->add('departement',EntityType::class,[
                     'class'=>Departement::class,
                     'choice_label'=>'libDepartement',
                     'choices'=>$departement,
                     'disabled'=>false,
                     'placeholder'=>'Selectionnez un village',
                     'constraints'=>new NotBlank(['message'=>'Selectionnez un village']),
                 ])   ;
             })

            ->add('nom')
            ->add('prenoms')
            ->add('cellule')
            ->add('codeParrainnage')
            ->add('quartier')
            ->add('sexe',ChoiceType::class,
                [
                    'expanded'     => false,
                    'placeholder' => 'VOTRE SEXE',
                    'required'     => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices'  => array_flip([
                        'FEMININ'        => 'F',
                        'MASCULIN'       => 'M',


                    ]),
                ])
            ->add('dateNaissance',DateType::Class, [
                "label"=> "Date de naissance",
                "required" => false,
                "widget" => 'single_text',
                "input_format"=>'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('lieuNaissance')
            ->add('niveauEtude')
            ->add('naturePiece',ChoiceType::class,
                [
                    'expanded'     => false,
                    'placeholder' => 'Nature piece',
                    'required'     => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices'  => array_flip([
                        'CNI'        => 'CNI',
                        'EXTRAIT'       => 'EXTRAIT',
                        'PASSEPORT'       => 'PASSEPORT',
                        'PERMIS'       => 'PERMIS DE CONDUIT',

                    ]),
                ])
            ->add('numeroPiece')
            ->add('lieuVote')
            ->add('preocupation',ChoiceType::class,
                [
                    'expanded'     => false,
                    'placeholder' => 'Choisir une pr??ocupation',
                    'required'     => true,
                    // 'attr' => ['class' => 'select2_multiple'],
                    'multiple' => false,
                    //'choices_as_values' => true,

                    'choices'  => array_flip([
                        'AIDE'        => 'AID',
                        'EMPLOI_STAGE'       => 'EMPLOI/STAGE',
                        'FINANCEMENT'       => 'FINANCEMENT',
                        'AUTRE'       => 'AUTRE',

                    ]),
                ])
            ->add('numeroCarteElecteur')
            ->add('email')
            ->add('contacts')
            ->add('dateCreation',DateType::Class, [
                "required" => false,
                "widget" => 'single_text',
                "input_format"=>'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
                'label'=>"Date creation",
            ])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('region', EntityType::class, [
                'class' => Localite::class,
                'placeholder'=>'Selectionnez une departement',
                'attr' => ['class' => 'js-select2-custom'],
                // 'disabled'=>true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'libelle',

            ])
            ->add('profession', EntityType::class, [
                'class' => Profession::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'choice_label' => 'libelle',

            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'placeholder'=>'Selectionnez un village',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'DESC');
                },
                'choice_label' => 'libDepartement',

            ])
            //->getForm();
        ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}