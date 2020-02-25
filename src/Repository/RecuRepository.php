<?php

namespace App\Repository;

use App\Entity\Recu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Recu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recu[]    findAll()
 * @method Recu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recu::class);
    }

    // /**
    //  * @return Recu[] Returns an array of Recu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recu
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
