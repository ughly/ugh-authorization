<?php

namespace UghAuthorization\Factory\Guards;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UghAuthorization\Guards\RouteGuard;

class RouteGuardFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\RbacService');

        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $routeGuards = $options->getRouteGuards();

        $controllerGuard = new RouteGuard($authorizationService, $routeGuards);

        return $controllerGuard;
    }

}
