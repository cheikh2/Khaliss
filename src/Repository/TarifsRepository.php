<?php

namespace App\Repository;

use App\Entity\Tarifs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tarifs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarifs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarifs[]    findAll()
 * @method Tarifs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarifs::class);
    }

    public function findByTarifs($somme)
    {
      return $this->createQueryBuilder('t')
            ->Where('t.borneInferieur <= :val')
            ->andWhere('t.borneSuperieur >= :val')
            ->setParameter('val', $somme)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Tarifs
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
