<?php

namespace App\Repository;

use App\Entity\Manufacturers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Manufacturers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manufacturers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manufacturers[]    findAll()
 * @method Manufacturers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManufacturersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Manufacturers::class);
    }

//    /**
//     * @return Manufacturers[] Returns an array of Manufacturers objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manufacturers
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
