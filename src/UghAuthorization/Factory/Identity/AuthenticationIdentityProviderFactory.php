<?php

namespace UghAuthorization\Factory\Identity;

use UghAuthorization\Identity\AuthenticationIdentityProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationIdentityProviderFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        return new AuthenticationIdentityProvider($authenticationService);
    }
}
