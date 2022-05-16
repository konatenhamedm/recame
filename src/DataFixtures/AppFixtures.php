<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use App\Entity\Groupe;
use App\Entity\Icons;
use App\Entity\Localite;
use App\Entity\Module;
use App\Entity\ModuleParent;
use App\Entity\Profession;
use App\Entity\User;
use App\Repository\LocaliteRepository;
use App\Repository\ModuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $module;
    private $departement;
    private $encode;

    public function __construct(ModuleRepository $repository,LocaliteRepository $localiteRepository, UserPasswordHasherInterface $encode)
    {
        $this->module = $repository->find(17);
        $this->encode = $encode;
        $this->departement = $localiteRepository;
    }

    public function load(ObjectManager $manager): void
    {



        $prefession = [
            "1"=>"OPERATEUR(RICE) ECONOMIQUE",
            "2"=>"AGRICULTEUR",
            "3"=>"ARTISAN(E)",
            "4"=>"ETUDIANT(E)",
            "5"=>"MENAGERE(E)",
            "6"=>"COMMERÇANT(E)",
            "7"=>"SANS-EMPLOI",
            "8"=>"OUVRIER(ERE)",
            "9"=>"ELEVE",
        ];

        foreach ($prefession as $prof){
           $profession = new Profession();
            $profession->setActive(1)
                       ->setLibelle($prof);
            $manager->persist($profession);
        }
        $parent = new ModuleParent();
        $parent->setTitre('PARAMETRAGES');
        $parent->setOrdre(2);
        $parent->setActive(1);
        $manager->persist($parent);

        $parent1 = new ModuleParent();
        $parent1->setTitre('NOTARI');
        $parent1->setOrdre(2);
        $parent1->setActive(1);
        $manager->persist($parent1);

        $user1 = new User();
        $password = "achi";
        $user1->setPassword($this->encode->hashPassword($user1, $password));
        $user1->setActive(1);
        $user1->setNom("Achi");
        $user1->setPrenoms("Achi");
        $user1->setEmail("achi@gmail.com");
        $manager->persist($user1);

        $icon1 = new Icons();

        $icon1->setCode("tio-circle");
        $icon1->setImage("");

        $manager->persist($icon1);

        $icon = new Icons();

        $icon->setCode("tio-apps");
        $icon->setImage("");

        $manager->persist($icon);

        $mod = new Module();
        $mod->setTitre('Général');
        $mod->setOrdre(1);
        $mod->setActive(1);
        $mod->setIcon($icon);
        $mod->setParent($parent);
        $manager->persist($mod);

        $mod2 = new Module();
        $mod2->setTitre('Gestion des actes')
            ->setOrdre(2)
            ->setActive(1)
            ->setIcon($icon)
            ->setParent($parent);
        $manager->persist($mod2);

        $mod1 = new Module();
        $mod1->setTitre('Gestion courriers');
        $mod1->setOrdre(2);
        $mod1->setActive(1);
        $mod1->setIcon($icon);
        $mod1->setParent($parent1);
        $manager->persist($mod1);

        $mod4 = new Module();
        $mod4->setTitre('Ressources humaines');
        $mod4->setOrdre(2);
        $mod4->setActive(1);
        $mod4->setIcon($icon);
        $mod4->setParent($parent1);
        $manager->persist($mod4);

        $groupe = new Groupe();
        $groupe->setIcon($icon1)
            ->setLien('courierInterne')
            ->setModule($mod1)
            ->setOrdre(3)
            ->setTitre('Courrier Interne');
        $manager->persist($groupe);

        $groupe1 = new Groupe();
        $groupe1->setIcon($icon1)
            ->setLien('courierArrive')
            ->setModule($mod1)
            ->setOrdre(1)
            ->setTitre('Courrier arrivé');
        $manager->persist($groupe1);

        $groupe2 = new Groupe();
        $groupe2->setIcon($icon1)
            ->setLien('courierDepart')
            ->setModule($mod1)
            ->setOrdre(2)
            ->setTitre('Courrier départ');
        $manager->persist($groupe2);

        $groupe3 = new Groupe();
        $groupe3->setIcon($icon1)
            ->setLien('type')
            ->setModule($mod2)
            ->setOrdre(1)
            ->setTitre('Type acte');
        $manager->persist($groupe3);

        $groupe6 = new Groupe();
        $groupe6->setIcon($icon1)
            ->setLien('acte')
            ->setModule($mod2)
            ->setOrdre(1)
            ->setTitre('Acte');
        $manager->persist($groupe6);

        $groupe4 = new Groupe();
        $groupe4->setIcon($icon1)
            ->setLien('client')
            ->setModule($mod4)
            ->setOrdre(1)
            ->setTitre('Client');
        $manager->persist($groupe4);

        $groupe5 = new Groupe();
        $groupe5->setIcon($icon1)
            ->setLien('calendar')
            ->setModule($mod4)
            ->setOrdre(1)
            ->setTitre('Evenements');
        $manager->persist($groupe5);


          $user = new User();

          $user->setNom('Konate')
              ->setemail('konatenhamed@gmail.com')
              ->setPrenoms('Hamed')
              ->setPassword($this->encode->hashPassword($user, "konate"))
              ->setActive(1);
        $manager->persist($user);
        /*  $mod = new Module();
          for ($i = 1; $i <= 2000; $i++) {
           $group[$i] = new Groupe();
           $group[$i]->setIcon("menu-bullet menu-bullet-line");
              $group[$i]->setOrdre(1);
              $group[$i]->setLien('parent');
             // $group[$i]->setModule($mod);
              $group[$i]->setTitre('parent');
              $manager->persist($group[$i]);
          }*/


        // $manager->persist($user);

        $manager->flush();
    }
}
