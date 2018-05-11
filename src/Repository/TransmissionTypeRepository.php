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

//    /**
//     * @return TransmissionType[] Returns an array of TransmissionType objects
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
    public function findOneBySomeField($value): ?TransmissionType
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
