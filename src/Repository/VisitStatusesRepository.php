<?php

namespace App\Repository;

use App\Entity\VisitStatuses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VisitStatuses|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitStatuses|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitStatuses[]    findAll()
 * @method VisitStatuses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitStatusesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VisitStatuses::class);
    }
}
