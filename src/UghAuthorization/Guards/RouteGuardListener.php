<?php

namespace UghAuthorization\Guards;

use Zend\Mvc\MvcEvent;

class RouteGuardListener extends GuardListener
{

    /**
     * 
     * @param MvcEvent $event
     */
    public function onGuard(MvcEvent $event)
    {
        $routeName = $event->getRouteMatch()->getMatchedRouteName();

        if ($this->guard->isGranted($routeName)) {
            return;
        }

        $this->triggerForbiddenEvent($event);
    }
}
