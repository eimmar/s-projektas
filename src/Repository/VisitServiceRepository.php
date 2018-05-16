<?php

namespace App\Repository;

use App\Entity\VisitService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VisitService|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitService|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitService[]    findAll()
 * @method VisitService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VisitService::class);
    }
}