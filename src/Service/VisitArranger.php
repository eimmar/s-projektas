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
    const STATUS_SUBMITTED = 'pending';
    const STATUS_CANCELLED = 'cancelled';

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
     * @param array $formData
     * @return VisitService|null
     */
    private function createVisitService($formData): ?VisitService
    {
        $serviceId = $formData ? $formData[AddServiceType::FIELD_SERVICE] : null;
        $service = $serviceId ? $this->serviceRepository->find($serviceId) : null;
        $visitService = null;

        if ($service) {
            $visitService = new VisitService();
            $visitService->setService($service);
        }

        return $visitService;
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
    public function initVisit(?array $formData = [])
    {
        $visit = $this->getUnfinishedArrangement();
        $visitService = $this->createVisitService($formData);

        if ($visitService && !$visit && $this->userHasVehicles()) {
            $visit = new Visit();
            $visit->setVehicle($this->user->getVehicles()->first())
                ->setVisitDate(new \DateTime('+1 hour'));
            $this->em->persist($visit);
        }

        if ($visitService) {
            $visit->addVisitService($visitService);
            $visit->calculateTotals();
            $this->em->persist($visitService);
            $this->em->flush();
        }

        return $visit;
    }

    /**
     * @param Visit|null $visit
     * @return bool
     */
    public function isVisitValid(?Visit $visit)
    {
        return $visit && $visit->getVisitServices()->count() > 0;
    }


    /**
     * @param Visit $visit
     */
    public function cancel(Visit $visit)
    {
        if ($visit->getStatus()->getName() === self::STATUS_NOT_SUBMITTED) {
            $this->em->remove($visit);
        } else {
            $visit->setStatus($this->statusRepository->findOneBy(['name' => self::STATUS_CANCELLED]));
            $this->em->persist($visit);
        }

        $this->em->flush();
    }

    /**
     * @param Visit $visit
     */
    public function submit(Visit $visit)
    {
        $visit->setStatus($this->statusRepository->findOneBy(['name' => self::STATUS_SUBMITTED]));
        $this->em->persist($visit);
        $this->em->flush();
    }
}
