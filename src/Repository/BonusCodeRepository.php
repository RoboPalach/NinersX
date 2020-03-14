<?php

namespace App\Repository;

use App\Entity\BonusCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BonusCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonusCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonusCode[]    findAll()
 * @method BonusCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonusCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonusCode::class);
    }

    // /**
    //  * @return BonusCode[] Returns an array of BonusCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BonusCode
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
