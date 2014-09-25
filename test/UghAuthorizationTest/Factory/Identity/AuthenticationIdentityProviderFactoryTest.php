<?php

namespace UghAuthorizationTest\Factory\Identity;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Identity\AuthenticationIdentityProviderFactory;
use Zend\ServiceManager\ServiceManager;

class AuthenticationIdentityProviderFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {

        $authenticationServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationService', array('getIdentity'))->disableOriginalConstructor()->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('Zend\Authentication\AuthenticationService', $authenticationServiceMock);

        $factory = new AuthenticationIdentityProviderFactory();

        $authenticationIdentityProvider = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Identity\AuthenticationIdentityProvider', $authenticationIdentityProvider);
    }
}
