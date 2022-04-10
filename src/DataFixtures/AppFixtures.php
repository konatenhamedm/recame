<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Module;
use App\Entity\ModuleParent;
use App\Repository\ModuleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $module;
    public function __construct(ModuleRepository $repository)
    {
        $this->module = $repository->find(17);
    }

    public function load(ObjectManager $manager): void
    {
       $parent = new ModuleParent();
        $parent->setTitre('PARAMETRAGES');
        $parent->setOrdre(2);
        $parent->setActive(1);
        $manager->persist($parent);

        $mod = new Module();
        $mod->setTitre('test');
        $mod->setOrdre(1);
        $mod->setActive(1);
        $mod->setIcon('yyyy');
        $mod->setParent( $parent );

        $manager->persist($mod);
      /*  $user = new User();

        $user->setName('konate')
            ->setemail('konatenhamed@gmail.com')
            ->setPassword('$2y$13$qo4/UPpc/bBO5ru6zXxnFuDwJxxnf5x1BbqvX5ugyLodW9rzqSY2S')
            ->setActive(1);*/

        $mod = new Module();
        for ($i = 1; $i <= 2000; $i++) {
         $group[$i] = new Groupe();
         $group[$i]->setIcon("menu-bullet menu-bullet-line");
            $group[$i]->setOrdre(1);
            $group[$i]->setLien('parent');
           // $group[$i]->setModule($mod);
            $group[$i]->setTitre('parent');
            $manager->persist($group[$i]);
        }


       // $manager->persist($user);

        $manager->flush();
    }
}
