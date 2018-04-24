<?php

namespace App\Repository;

use App\Entity\TransmitionTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TransmitionTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransmitionTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransmitionTypes[]    findAll()
 * @method TransmitionTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransmitionTypesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TransmitionTypes::class);
    }

//    /**
//     * @return TransmitionTypes[] Returns an array of TransmitionTypes objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TransmitionTypes
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
