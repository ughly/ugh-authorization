<?php

namespace UghAuthorizationTest\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Guards\RouteGuard;

class RouteGuardTest extends PHPUnit_Framework_TestCase
{

    private $authorizationServiceMock;

    public function setUp()
    {
        $this->authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('matchIdentityRoles'))->disableOriginalConstructor()->getMock();
    }

    public function testCanGuardRoutes()
    {
        $this->authorizationServiceMock->expects($this->any())->method('matchIdentityRoles')->will($this->returnValue(false));

        $routeGuard = new RouteGuard($this->authorizationServiceMock, array(
            'secure' => array('member')
        ));

        $this->assertFalse($routeGuard->isGranted('secure'));
    }

    public function testCanGrantAccessForRoute()
    {
        $this->authorizationServiceMock->expects($this->any())->method('matchIdentityRoles')->will($this->returnValue(true));

        $routeGuard = new RouteGuard($this->authorizationServiceMock, array(
            'secure' => array('member')
        ));

        $this->assertTrue($routeGuard->isGranted('secure'));
    }

    public function testAllowedRolesByRouteName()
    {
        $routeGuard = new RouteGuard($this->authorizationServiceMock, array(
            'home' => array('guest'),
            'secure' => array('member'),
            'secure*' => array('admin')
        ));

        $this->assertEquals(array('member', 'admin'), $routeGuard->getAllowedRolesByRouteName('secure'));
        $this->assertEquals(array('admin'), $routeGuard->getAllowedRolesByRouteName('secure/admin'));
    }
}
