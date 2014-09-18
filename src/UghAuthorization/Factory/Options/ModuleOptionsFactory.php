<?php

namespace UghAuthorization\Factory\Options;

use UghAuthorization\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new ModuleOptions($config['ugh_authorization']);
    }
}
