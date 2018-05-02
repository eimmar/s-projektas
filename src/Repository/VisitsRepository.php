<?php

namespace App\Repository;

use App\Entity\Visits;
use Doctrine\Bundle\DoctrineBundle\Repository\VisitsEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Visits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visits[]    findAll()
 * @method Visits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Visits::class);
    }
}
