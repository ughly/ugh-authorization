<?php

namespace UghAuthorization\Factory\Authorization;

use UghAuthorization\Authorization\AuthorizationEventListener;
use UghAuthorization\Authorization\AuthorizationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorizationEventListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $authorizationService AuthorizationService */
        $authorizationService = $serviceLocator->get('UghAuthorization\Authorization\AuthorizationService');

        return new AuthorizationEventListener($authorizationService);
    }
}
