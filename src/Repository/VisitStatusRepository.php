<?php

namespace App\Repository;

use App\Entity\VisitStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VisitStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitStatus[]    findAll()
 * @method VisitStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VisitStatus::class);
    }
}