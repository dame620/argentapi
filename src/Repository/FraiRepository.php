<?php

namespace App\Repository;

use App\Entity\Frai;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Frai|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frai|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frai[]    findAll()
 * @method Frai[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Frai::class);
    }

    // /**
    //  * @return Frai[] Returns an array of Frai objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Frai
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findOneBymontant($montant): ?Frai
    {
        return $this->createQueryBuilder('f')
            ->Where('f.borneinf <= :val')
            ->andWhere('f.bornesup >= :val')
            ->setParameter('val',$montant)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
