<?php

namespace UghAuthorization\Factory\Guards;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use UghAuthorization\Guards\ControllerGuard;
use Zend\View\Model\ViewModel;

class ControllerGuardFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\AuthorizationService');

        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $controllerGuards = $options->getcontrollerGuards();

        $controllerGuard = new ControllerGuard($authorizationService, $controllerGuards);

        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->get403Template());

        $controllerGuard->setErrorViewModel($viewModel);

        return $controllerGuard;
    }
}
