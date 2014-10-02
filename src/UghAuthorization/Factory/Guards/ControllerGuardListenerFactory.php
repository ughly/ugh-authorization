<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\ControllerGuardListener;
use UghAuthorization\Guards\Guard;
use UghAuthorization\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class ControllerGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options ModuleOptions */
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');

        /* @var $controllerGuard Guard */
        $controllerGuard = $serviceLocator->get('UghAuthorization\Guards\ControllerGuard');

        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->getUnauthorizedViewScript());

        $controllerGuardListener = new ControllerGuardListener($controllerGuard);
        $controllerGuardListener->setErrorViewModel($viewModel);

        return $controllerGuardListener;
    }
}
