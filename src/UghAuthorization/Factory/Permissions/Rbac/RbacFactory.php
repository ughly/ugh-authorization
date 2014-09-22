<?php

namespace UghAuthorization\Factory\Permissions\Rbac;

use Zend\Permissions\Rbac\Rbac;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RbacFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $identityProvider = $serviceLocator->get('UghAuthorization\Authentication\IdentityProvider');

        $roleProvider = $serviceLocator->get('UghAuthorization\Permissions\Rbac\RoleProvider');

        $roles = $roleProvider->getRoles($identityProvider->getRoles());

        $rbac = new Rbac();

        foreach ($roles as $role) {
            $rbac->addRole($role);
        }

        return $rbac;
    }
}
