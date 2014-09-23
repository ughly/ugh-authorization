<?php

namespace UghAuthorizationTest\Factory\Permissions\Rbac;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Permissions\Rbac\RbacFactory;
use UghAuthorization\Options\ModuleOptions;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\ServiceManager;

class RbacFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $identityMock = $this->getMockBuilder('UghAuthorization\Identity\Identity', array('getRoles'))->disableOriginalConstructor()->getMock();
        $identityMock->expects($this->once())->method('getRoles')->will($this->returnValue(array('admin')));

        $identityProviderMock = $this->getMockBuilder('UghAuthorization\Identity\IdentityProvider', array('getIdentity'))->disableOriginalConstructor()->getMock();
        $identityProviderMock->expects($this->once())->method('getIdentity')->will($this->returnValue($identityMock));

        $roleProviderMock = $this->getMockBuilder('UghAuthorization\Permissions\Rbac\RoleProvider', array('getRoles'))->disableOriginalConstructor()->getMock();
        $roleProviderMock->expects($this->once())->method('getRoles')->will($this->returnValue(array(new Role('admin'))));

        $moduleOptions = new ModuleOptions(array('identity_provider' => 'UghAuthorization\Identity\IdentityProvider', 'role_provider' => 'UghAuthorization\Permissions\Rbac\RoleProvider'));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Permissions\Rbac\RoleProvider', $roleProviderMock);
        $serviceManager->setService('UghAuthorization\Identity\IdentityProvider', $identityProviderMock);
        $serviceManager->setService('UghAuthorization\Options\ModuleOptions', $moduleOptions);

        $factory = new RbacFactory();

        $rbac = $factory->createService($serviceManager);

        $this->assertTrue($rbac->hasRole('admin'));
        $this->assertInstanceOf('Zend\Permissions\Rbac\Rbac', $rbac);
    }
}