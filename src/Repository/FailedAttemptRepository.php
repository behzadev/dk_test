<?php

namespace App\Repository;

use App\Entity\FailedAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FailedAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method FailedAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method FailedAttempt[]    findAll()
 * @method FailedAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FailedAttemptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FailedAttempt::class);
    }

    // /**
    //  * @return FailedAttempt[] Returns an array of FailedAttempt objects
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
    public function findOneBySomeField($value): ?FailedAttempt
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
