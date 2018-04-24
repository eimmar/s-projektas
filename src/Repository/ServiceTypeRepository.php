<?php

namespace App\Repository;

use App\Entity\ServiceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ServiceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceType[]    findAll()
 * @method ServiceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ServiceType::class);
    }

    /**
     * @param $serviceType
     * @return QueryBuilder
     */
    public function getServiceListQuery(ServiceType $serviceType)
    {
        return $this->getEntityManager()
            ->getRepository('App:Service')
            ->getBaseListQuery()
            ->where('st = :serviceType')
            ->setParameter('serviceType', $serviceType);
    }
}
