<?php

namespace App\Repository;

use App\Entity\FailedAttempts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FailedAttempts|null find($id, $lockMode = null, $lockVersion = null)
 * @method FailedAttempts|null findOneBy(array $criteria, array $orderBy = null)
 * @method FailedAttempts[]    findAll()
 * @method FailedAttempts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FailedAttemptsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FailedAttempts::class);
    }

    // /**
    //  * @return FailedAttempts[] Returns an array of FailedAttempts objects
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
    public function findOneBySomeField($value): ?FailedAttempts
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
