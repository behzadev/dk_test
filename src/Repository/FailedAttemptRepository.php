<?php

namespace App\Repository;

use App\Entity\FailedAttempt;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * returns one row with minimum attempt
     *
     * @return void
     */
    public function rowWithMinimumAttempts()
    {
        return $this->createQueryBuilder('fa')
            ->select('fa.id as id, fa.number, fa.body')
            ->orderBy('id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
