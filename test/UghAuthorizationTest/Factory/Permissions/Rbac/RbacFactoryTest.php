<?php

namespace UghAuthorizationTest\Factory\Permissions\Rbac;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Permissions\Rbac\RbacFactory;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\ServiceManager;

class RbacFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $roleProviderMock = $this->getMockBuilder('UghAuthorization\Permissions\Rbac\RoleProvider', array('getRoles'))->disableOriginalConstructor()->getMock();
        $roleProviderMock->expects($this->once())->method('getRoles')->will($this->returnValue(array(new Role('admin'))));
        
        $identityProvderMock = $this->getMockBuilder('UghAuthorization\Authentication\IdentityProvider', array('getRoles'))->disableOriginalConstructor()->getMock();
        $identityProvderMock->expects($this->once())->method('getRoles')->will($this->returnValue(array('admin')));
        
        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Permissions\Rbac\RoleProvider', $roleProviderMock);
        $serviceManager->setService('UghAuthorization\Authentication\IdentityProvider', $identityProvderMock);
        
        $factory = new RbacFactory();
        
        $rbac = $factory->createService($serviceManager);
        
        $this->assertTrue($rbac->hasRole('admin'));
        $this->assertInstanceOf('Zend\Permissions\Rbac\Rbac', $rbac);
    }
}
