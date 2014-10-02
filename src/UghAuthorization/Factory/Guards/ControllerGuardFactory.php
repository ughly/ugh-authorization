<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Authorization\AuthorizationService;
use UghAuthorization\Guards\ControllerGuard;
use UghAuthorization\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerGuardFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $authorizationService AuthorizationService */
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\AuthorizationService');

        /* @var $options ModuleOptions */
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $controllerGuards = $options->getcontrollerGuards();

        $controllerGuard = new ControllerGuard($authorizationService, $controllerGuards);

        return $controllerGuard;
    }
}
