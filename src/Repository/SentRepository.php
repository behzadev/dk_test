<?php

namespace App\Repository;

use App\Entity\Sent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sent[]    findAll()
 * @method Sent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sent::class);
    }

    // /**
    //  * @return Sent[] Returns an array of Sent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
