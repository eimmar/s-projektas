<?php

namespace App\Repository;

use App\Entity\Service;
use App\Form\SearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Service::class);
    }

    /**
     * @param ParameterBag $params
     * @return QueryBuilder
     */
    public function getPaginationListQuery($params = null)
    {
        $searchTerm = $params ? trim($params->get('search')['search']) : '';

        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.serviceType', 'st')
            ->where('s.isActive = 1');

        if ($searchTerm !== '') {
            $qb
                ->addSelect("(MATCH (s.name, s.description) AGAINST (:searchTerm BOOLEAN) + MATCH (st.name) AGAINST (:searchTerm BOOLEAN)) as score")
                ->andWhere('(MATCH (s.name, s.description) AGAINST (:searchTerm BOOLEAN) + MATCH (st.name) AGAINST (:searchTerm BOOLEAN)) > 0')
                ->setParameter('searchTerm', $searchTerm . '*')
                ->orderBy('score', 'desc');
        }

        return $qb;
    }
}
