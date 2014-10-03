<?php

namespace UghAuthorization\Factory\Permissions\Rbac;

use UghAuthorization\Permissions\Rbac\RoleProviderPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleProviderPluginManagerFactory implements FactoryInterface
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return RoleProviderPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $roleProviderPluginManager = new RoleProviderPluginManager();
        $roleProviderPluginManager->setServiceLocator($serviceLocator);

        return $roleProviderPluginManager;
    }
}
