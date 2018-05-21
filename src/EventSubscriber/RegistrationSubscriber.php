<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var array
     */
    private $redirectRoutes;

    /**
     * RegistrationListener constructor.
     * @param UrlGeneratorInterface $router
     * @param array $redirectRoutes
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
        $this->redirectRoutes = [
            'fos_user_registration_register',
            'fos_user_security_login',
        ];
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if (in_array($request->get('_route'), $this->redirectRoutes, true)
            && $request->getSession()->get('_security_main')
        ) {
            $route = $this->router->generate('homepage');
            $event->setResponse(new RedirectResponse($route));
        }
    }
}
