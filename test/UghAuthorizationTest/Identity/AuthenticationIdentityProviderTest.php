<?php

namespace UghAuthorizationTest\Identity;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Identity\AuthenticationIdentityProvider;

class AuthenticationIdentityProviderTest extends PHPUnit_Framework_TestCase
{

    public function testCanGetIdentity()
    {
        $identityMock = $this->getMock('UghAuthorization\Identity\Identity');

        $authenticationServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationServiceInterface', array('getIdentity'))->disableOriginalConstructor()->getMock();
        $authenticationServiceMock->expects($this->once())->method('getIdentity')->will($this->returnValue($identityMock));

        $authenticationIdentityProvider = new AuthenticationIdentityProvider($authenticationServiceMock);

        $this->assertInstanceOf('UghAuthorization\Identity\Identity', $authenticationIdentityProvider->getIdentity());
    }

    public function testCanGetAnonymousIdentity()
    {
        $authenticationServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationServiceInterface', array('getIdentity'))->disableOriginalConstructor()->getMock();
        $authenticationServiceMock->expects($this->once())->method('getIdentity')->will($this->returnValue(null));

        $authenticationIdentityProvider = new AuthenticationIdentityProvider($authenticationServiceMock);

        $this->assertInstanceOf('UghAuthorization\Identity\AnonymousIdentity', $authenticationIdentityProvider->getIdentity());
    }
}
