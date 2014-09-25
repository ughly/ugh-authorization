<?php

namespace UghAuthorizationTest\Factory\Authorization;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Authorization\RbacServiceFactory;
use UghAuthorization\Identity\AnonymousIdentity;
use Zend\Permissions\Rbac\Rbac;
use Zend\ServiceManager\ServiceManager;

class RbacServiceFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $authenticationIdentityProviderMock = $this->getMockBuilder('UghAuthorization\Identity\IdentityProvider', array('getIdentity'))->disableOriginalConstructor()->getMock();
        $authenticationIdentityProviderMock->expects($this->once())->method('getIdentity')->will($this->returnValue(new AnonymousIdentity()));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Identity\AuthenticationIdentityProvider', $authenticationIdentityProviderMock);
        $serviceManager->setService('UghAuthorization\Permissions\Rbac\Rbac', new Rbac());

        $factory = new RbacServiceFactory();

        $rbacService = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Authorization\RbacService', $rbacService);
    }
}
