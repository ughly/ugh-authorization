<?php

namespace UghAuthorization\Guards;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class RouteGuardListener extends AbstractListenerAggregate
{

    /** @var Guard */
    private $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onGuard'));
    }

    public function onGuard(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();

        if ($this->guard->isGranted($routeName)) {
            return;
        }
        
        $this->triggerForbiddenEvent($event);
    }
    
    private function triggerForbiddenEvent(MvcEvent $event)
    {
        $event->setError('route-forbidden');
        $event->setParam('exception', new \Exception('You are forbidden!', 403));
        
        $event->stopPropagation(true);
        
        $application  = $event->getApplication();
        $eventManager = $application->getEventManager();

        $eventManager->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

}
