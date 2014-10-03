<?php

namespace UghAuthorization\Factory\Identity;

use UghAuthorization\Identity\AuthenticationIdentityProvider;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationIdentityProviderFactory implements FactoryInterface
{

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationIdentityProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $authenticationService AuthenticationServiceInterface */
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');

        return new AuthenticationIdentityProvider($authenticationService);
    }
}
