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
}
