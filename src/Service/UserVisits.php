<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

Class UserVisits
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    public function vehicle()
    {
        return $this->entityManager->getRepository('App:Vehicles')->findAll();
    }
    public function service()
    {
        return $this->entityManager->getRepository('App:Service')->findAll();
    }
    public function visits()
    {
        return $this->entityManager->getRepository('App:Visits')->findAll();
    }
    public function cancelVisit()
    {

    }

}