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

        $user = new User();
        $password = "achi";
        $user->setPassword($this->encode->hashPassword($user, $password));
        $user->setActive(1);
        $user->setNom("Achi");
        $user->setPrenoms("Achi");
        $user->setEmail("achi@gmail.com");
        $manager->persist($user);

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
          $user = new User();

          $user->setNom('Konate')
              ->setemail('konatenhamed@gmail.com')
              ->setPrenoms('Hamed')
              ->setPassword('$2y$13$qo4/UPpc/bBO5ru6zXxnFuDwJxxnf5x1BbqvX5ugyLodW9rzqSY2S')
              ->setActive(1);

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
