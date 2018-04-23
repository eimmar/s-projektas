<?php

namespace App\Repository;

use App\Entity\FuelTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FuelTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuelTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuelTypes[]    findAll()
 * @method FuelTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelTypesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FuelTypes::class);
    }

//    /**
//     * @return FuelTypes[] Returns an array of FuelTypes objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FuelTypes
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
