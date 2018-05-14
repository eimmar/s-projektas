<?php

namespace App\Repository;

use App\Entity\ServiceHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceHistory[]    findAll()
 * @method ServiceHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceHistory::class);
    }
}