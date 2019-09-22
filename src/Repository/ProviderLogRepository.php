<?php

namespace App\Repository;

use App\Entity\ProviderLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProviderLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProviderLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProviderLog[]    findAll()
 * @method ProviderLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProviderLog::class);
    }

    // /**
    //  * @return ProviderLog[] Returns an array of ProviderLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProviderLog
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
