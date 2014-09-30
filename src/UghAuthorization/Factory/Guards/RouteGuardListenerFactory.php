<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\RouteGuardListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class RouteGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $routeGuard = $serviceLocator->get('UghAuthorization\Guards\RouteGuard');
        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->get403Template());

        $routeGuardListener = new RouteGuardListener($routeGuard);
        $routeGuardListener->setErrorViewModel($viewModel);

        return $routeGuardListener;
    }
}
