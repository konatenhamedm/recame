<?php

namespace App\Repository;

use App\Entity\Membre;
use App\Entity\Module;
use App\Entity\ModuleParent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Membre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Membre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Membre[]    findAll()
 * @method Membre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membre::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Membre $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Membre $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findLastChrono($departement){
        return $this->createQueryBuilder("m")
            ->select("m")
            ->join("m.departement","d")
            ->where("d.libDepartement = :departement")
            ->setParameter("departement", $departement)
            ->getQuery()
            ->getResult();

        /*return $this->createQueryBuilder('i')
            ->innerJoin('i.customer','c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;*/
    }

    public function getNombre(){
        return $this->createQueryBuilder("m")
            ->select("count(m.id)")
            ->getQuery()
            ->getSingleScalarResult();
    }

    // /**
    //  * @return Membre[] Returns an array of Membre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Membre
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
