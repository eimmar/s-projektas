<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    /**
     * @param User $user
     * @return QueryBuilder
     */
    private function getUserVisitQb(User $user)
    {
        return $this->createQueryBuilder('v')
            ->where('v.vehicle in (:vehicles)')
            ->setParameter('vehicles', $user->getVehicles());
    }

    public function findUserVisits(User $user)
    {
        return $this->getUserVisitQb($user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     * @param string $statusName
     * @return Visit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserVisitsByStatus(User $user, string $statusName)
    {
        return $this->getUserVisitQb($user)
            ->leftJoin('v.status', 's')
            ->andWhere('s.name = :status')
            ->setParameter('status', $statusName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Vehicle $vehicle
     * @return Vehicle[]|null
     */
    public function getUnfinishedVehicleVisits(Vehicle $vehicle)
    {
        return $this->createQueryBuilder('v')
            ->where('v.vehicle = :vehicle')
            ->leftJoin('v.status', 's')
            ->andWhere('s.isResolved = 0')
            ->setParameters(['vehicle' => $vehicle])
            ->getQuery()
            ->getResult();
    }
}
