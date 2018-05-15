<?php

namespace App\Repository;

use App\Entity\TransmissionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TransmissionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransmissionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransmissionType[]    findAll()
 * @method TransmissionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransmissionTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TransmissionType::class);
    }
}
