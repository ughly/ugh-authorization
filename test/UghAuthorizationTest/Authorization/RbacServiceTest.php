<?php

namespace UghAuthorizationTest\Authorization;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Authorization\RbacService;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

class RbacServiceTest extends PHPUnit_Framework_TestCase
{
    public function testDenyGuestAccess()
    {
        $guestRole = new Role('guest');
        
        $rbac = new Rbac();
        $rbac->addRole($guestRole);
        
        $authorizationService = new RbacService($rbac, array('guest'));
        
        $this->assertFalse($authorizationService->isGranted('delete'));
    }
    
    public function testDenyUnidentifiedUserAccess()
    {
        $authorizationService = new RbacService(new Rbac(), array());
        
        $this->assertFalse($authorizationService->isGranted('read'));
    }
    
    public function testAllowAdminAccess()
    {
        $adminRole = new Role('admin');
        $adminRole->addPermission('delete');
        
        $rbac = new Rbac();
        $rbac->addRole($adminRole);
        
        $authorizationService = new RbacService($rbac, array('admin'));
        
        $this->assertTrue($authorizationService->isGranted('delete'));
    }
    
    public function testCanMatchIdentityRoles()
    {
        $adminRole = new Role('admin');
        $adminRole->addPermission('delete');
        
        $rbac = new Rbac();
        $rbac->addRole($adminRole);
        
        $authorizationService = new RbacService($rbac, array('admin'));
        
        $this->assertTrue($authorizationService->matchIdentityRoles(array('admin')));
    }
}
