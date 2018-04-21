<?php

namespace App\Repository;

use App\Entity\CompanyAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompanyAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyAddress[]    findAll()
 * @method CompanyAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyAddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompanyAddress::class);
    }
}
