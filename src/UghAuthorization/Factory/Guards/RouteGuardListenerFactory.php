<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\RouteGuardListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $routeGuard = $serviceLocator->get('UghAuthorization\Guards\RouteGuard');

        return new RouteGuardListener($routeGuard);
    }
}
