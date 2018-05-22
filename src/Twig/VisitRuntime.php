<?php

namespace App\Twig;


use App\Entity\User;
use App\Entity\Visit;
use App\Repository\VisitRepository;

class VisitRuntime
{
    /**
     * @var VisitRepository
     */
    private $visitRepository;

    /**
     * VisitExtension constructor.
     * @param VisitRepository $visitRepository
     */
    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    /**
     * @param User $user
     * @return \App\Entity\Visit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCurrentVisit(User $user)
    {
        return $this->visitRepository->getUserVisitsByStatus($user, Visit::STATUS_NOT_SUBMITTED);
    }
}
