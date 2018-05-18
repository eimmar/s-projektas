<?php

namespace App\EventSubscriber;


use App\Entity\Visit;
use App\Service\VisitArranger;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class VisitSubscriber implements EventSubscriber
{
    /**
     * @return array The event names to listen to
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist => 'prePersist'
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Visit) {
            $entityManager = $args->getObjectManager();
            $entity->setStatus(
                $entityManager->getRepository('App:VisitStatus')
                    ->findOneBy(['name' => VisitArranger::STATUS_NOT_SUBMITTED])
            );
        }
    }
}
