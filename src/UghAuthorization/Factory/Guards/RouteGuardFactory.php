<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Authorization\AuthorizationService;
use UghAuthorization\Guards\RouteGuard;
use UghAuthorization\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteGuardFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $authorizationService AuthorizationService */
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\AuthorizationService');

        /* @var $options ModuleOptions */
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $routeGuards = $options->getRouteGuards();

        $routeGuard = new RouteGuard($authorizationService, $routeGuards);

        return $routeGuard;
    }
}
