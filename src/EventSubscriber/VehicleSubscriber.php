<?php

namespace App\EventSubscriber;


use App\Entity\Vehicle;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class VehicleSubscriber implements EventSubscriber
{
    /**
     * @return array The event names to listen to
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preRemove => 'preRemove'
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Vehicle) {
            $objectManager = $args->getObjectManager();
            foreach ($entity->getVisits() as $visit) {
                $entity->removeVisit($visit);
                $visit->isUnSubmitted() ? $objectManager->remove($visit) : null;
            }
        }
    }
}
