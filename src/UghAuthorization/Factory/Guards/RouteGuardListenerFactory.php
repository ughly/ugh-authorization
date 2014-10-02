<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\Guard;
use UghAuthorization\Guards\RouteGuardListener;
use UghAuthorization\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class RouteGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options ModuleOptions */
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');

        /* @var $routeGuard Guard */
        $routeGuard = $serviceLocator->get('UghAuthorization\Guards\RouteGuard');

        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->getUnauthorizedViewScript());

        $routeGuardListener = new RouteGuardListener($routeGuard);
        $routeGuardListener->setErrorViewModel($viewModel);

        return $routeGuardListener;
    }
}
