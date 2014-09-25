<?php

namespace UghAuthorization\Factory\Authorization;

use UghAuthorization\Authorization\RbacService;
use UghAuthorization\Identity\AuthenticationIdentityProvider;
use Zend\Permissions\Rbac\Rbac;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RbacServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $rbac Rbac */
        $rbac = $serviceLocator->get('UghAuthorization\Permissions\Rbac\Rbac');

        /* @var $authenticationIdentityProvider AuthenticationIdentityProvider */
        $authenticationIdentityProvider = $serviceLocator->get('UghAuthorization\Identity\AuthenticationIdentityProvider');

        $identity = $authenticationIdentityProvider->getIdentity();

        return new RbacService($rbac, $identity->getRoles());
    }
}
