<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function getActiveVisits(User $user)
    {
        return $this->createQueryBuilder('v')
            ->where('v.vehicle in :vehicles')
            ->setParameter('vehicles', $user->getVehicles())
            ->getQuery()
            ->getResult();
    }
}
