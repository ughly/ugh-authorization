<?php

namespace UghAuthorization\Factory\Permissions\Rbac;

use UghAuthorization\Identity\IdentityProvider;
use UghAuthorization\Options\ModuleOptions;
use UghAuthorization\Permissions\Rbac\RoleProvider;
use UghAuthorization\Permissions\Rbac\RoleProviderPluginManager;
use Zend\Permissions\Rbac\Rbac;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RbacFactory implements FactoryInterface
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Rbac
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $moduleOptions ModuleOptions */
        $moduleOptions = $serviceLocator->get('UghAuthorization\Options\ModuleOptions');

        /* @var $pluginManager RoleProviderPluginManager */
        $pluginManager = $serviceLocator->get('UghAuthorization\Permissions\Rbac\RoleProviderPluginManager');

        $roleProviderConfig = $moduleOptions->getRoleProvider();

        /* @var $roleProvider RoleProvider */
        $roleProvider = $pluginManager->get(key($roleProviderConfig), current($roleProviderConfig));

        /* @var $identityProvider IdentityProvider */
        $identityProvider = $serviceLocator->get($moduleOptions->getIdentityProvider());

        $identity = $identityProvider->getIdentity();

        $roles = $roleProvider->getRoles($identity->getRoles());

        $rbac = new Rbac();

        foreach ($roles as $role) {
            $rbac->addRole($role);
        }

        return $rbac;
    }
}
