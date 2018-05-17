<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\Visit;
use App\Entity\VisitService;
use App\Form\AddServiceType;
use App\Repository\ServiceRepository;
use App\Repository\VisitRepository;
use App\Repository\VisitStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VisitArranger
{
    const STATUS_NOT_SUBMITTED = 'not_submitted';

    /**
     * @var VisitRepository
     */
    private $visitRepository;

    /**
     * @var VisitStatusRepository
     */
    private $statusRepository;

    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * VisitArranger constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage){
        $this->visitRepository = $em->getRepository('App:Visit');
        $this->statusRepository = $em->getRepository('App:VisitStatus');
        $this->serviceRepository = $em->getRepository('App:Service');
        $this->em = $em;
        $this->user = $tokenStorage->getToken()->getUser();
    }


    /**
     * @return Visit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUnfinishedArrangement()
    {
        return $this->visitRepository->getUnsubmittedVisit($this->user);
    }

    /**
     * @return bool
     */
    public function userHasVehicles()
    {
        return $this->user->getVehicles()->count() > 0;
    }

    /**
     * @param array|null $formData
     * @return Visit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function initVisit(?array $formData)
    {
        $visit = $this->getUnfinishedArrangement() ?? new Visit();

        $serviceId = $formData ? $formData[AddServiceType::FIELD_SERVICE] : null;
        $visitService = $serviceId ? $this->createVisitService($serviceId) : null;

        if ($visitService) {
            $visit->setVehicle($visit->getVehicle() ?? $this->user->getVehicles()->first())
                ->addVisitService($visitService)
                ->setStatus($this->statusRepository->findOneBy(['name' => self::STATUS_NOT_SUBMITTED])) //TODO: Maybe move this to event listener?
                ->setVisitDate($visit->getVisitDate() ?? new \DateTime('+1 hour'))
                ->calculateTotals();

            $this->em->persist($visitService);
            $this->em->persist($visit);
            $this->em->flush();
        }

        return $visit;
    }

    /**
     * @param Visit $visit
     * @return bool
     */
    public function isVisitValid(Visit $visit)
    {
        return $visit->getVisitServices()->count() > 0;
    }

    /**
     * @param int $serviceId
     * @return VisitService|null
     */
    private function createVisitService(int $serviceId): ?VisitService
    {
        $service = $this->serviceRepository->find($serviceId);
        $visitService = null;

        if ($service) {
            $visitService = new VisitService();
            $visitService->setService($service);
        }

        return $visitService;
    }
}
