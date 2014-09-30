<?php

namespace UghAuthorization\Factory\Guards;

use UghAuthorization\Guards\ControllerGuardListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class ControllerGuardListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');
        $controllerGuard = $serviceLocator->get('UghAuthorization\Guards\ControllerGuard');
        $viewModel = new ViewModel();
        $viewModel->setTemplate($options->get403Template());

        $controllerGuardListener = new ControllerGuardListener($controllerGuard);
        $controllerGuardListener->setErrorViewModel($viewModel);

        return $controllerGuardListener;
    }
}
