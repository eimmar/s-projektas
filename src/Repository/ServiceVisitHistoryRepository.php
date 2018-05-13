<?php

namespace App\Repository;

use App\Entity\ServiceVisitHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceVisitHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceVisitHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceVisitHistory[]    findAll()
 * @method ServiceVisitHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceVisitHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceVisitHistory::class);
    }
}