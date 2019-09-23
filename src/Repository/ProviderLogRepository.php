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

    /**
     * To count all sent sms groupby provider
     *
     * @return array
     */
    public function getAllLog(): array
    {
        return $this->createQueryBuilder('log')
            ->select('log.success_count, log.failed_count')
            ->getQuery()
            ->getResult();
    }
}
