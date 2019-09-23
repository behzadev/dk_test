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

    /**
     * To count all sent SMS
     *
     * @return int
     */
    public function countAll()
    {
        return $this->createQueryBuilder('sms')
            ->select('COUNT(sms)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * To count all sent sms groupby provider
     *
     * @return array
     */
    public function countForProviders()
    {
        return $this->createQueryBuilder('sms')
            ->select('COUNT(sms)')
            ->groupby('sms.provider')
            ->getQuery()
            ->getResult();
    }

    /**
     * Most 10 message recivers
     *
     * @return array
     */
    public function mostTenMessageReceivers()
    {
        return $this->createQueryBuilder('sms')
            ->select('sms.number AS number, COUNT(sms) as COUNT')
            ->groupby('number')
            ->setMaxResults(10)
            ->orderBy('COUNT', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
