<?php

namespace UghAuthorization\Factory\Guards;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UghAuthorization\Guards\RouteGuard;
use Zend\View\Model\ViewModel;

class RouteGuardFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\AuthorizationService');

        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $routeGuards = $options->getRouteGuards();

        $routeGuard = new RouteGuard($authorizationService, $routeGuards);

        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->get403Template());

        $routeGuard->setErrorViewModel($viewModel);

        return $routeGuard;
    }
}
