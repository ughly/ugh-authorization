<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\ControllerGuardListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controllerGuard = $serviceLocator->get('UghAuthorization\Guards\ControllerGuard');

        return new ControllerGuardListener($controllerGuard);
    }
}
