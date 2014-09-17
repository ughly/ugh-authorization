<?php

namespace UghAuthorization\Guards;

use Zend\Mvc\MvcEvent;

class ControllerGuardListener extends GuardListener
{

    public function onGuard(MvcEvent $event)
    {
        $controllerName = $event->getRouteMatch()->getParam('controller');
        $actionName = $event->getRouteMatch()->getParam('action');

        if ($this->guard->isGranted(array('controller' => $controllerName, 'action' => $actionName))) {
            return;
        }

        $this->triggerForbiddenEvent($event);
    }

}
