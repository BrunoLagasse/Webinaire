<?php

namespace App\Repository;

use App\Entity\Obj;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Obj|null find($id, $lockMode = null, $lockVersion = null)
 * @method Obj|null findOneBy(array $criteria, array $orderBy = null)
 * @method Obj[]    findAll()
 * @method Obj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Obj::class);
    }

    // /**
    //  * @return Obj[] Returns an array of Obj objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Obj
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
