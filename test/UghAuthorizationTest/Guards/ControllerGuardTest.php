<?php

namespace UghAuthorizationTest\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Guards\ControllerGuard;

class ControllerGuardTest extends PHPUnit_Framework_TestCase
{

    private $authorizationServiceMock;

    public function setUp()
    {
        $this->authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('matchIdentityRoles'))->disableOriginalConstructor()->getMock();
    }

    public function testCanGuardControllers()
    {
        $this->authorizationServiceMock->expects($this->any())->method('matchIdentityRoles')->will($this->returnValue(false));

        $controllerGuard = new ControllerGuard($this->authorizationServiceMock, array(array(
                'controller' => 'index',
                'actions' => array('update', 'delete'),
                'roles' => array('member', 'editor')
            )
        ));

        $this->assertFalse($controllerGuard->isGranted(array('controller' => 'foo', 'action' => 'bar')));
    }

    public function testCanGrantAccessForControllers()
    {
        $this->authorizationServiceMock->expects($this->any())->method('matchIdentityRoles')->will($this->returnValue(true));

        $controllerGuard = new ControllerGuard($this->authorizationServiceMock, array(array(
                'controller' => 'index',
                'actions' => array('update', 'delete'),
                'roles' => array('member', 'editor')
            )
        ));

        $this->assertTrue($controllerGuard->isGranted(array('controller' => 'foo', 'action' => 'bar')));
    }

    public function testAllowedRolesByControllerAction()
    {
        $controllerGuard = new ControllerGuard($this->authorizationServiceMock, array(
            array(
                'controller' => 'index',
                'actions' => array('update', 'delete'),
                'roles' => array('member', 'editor')
            ),
            array(
                'controller' => 'foo',
                'actions' => array('bar', 'foo'),
                'roles' => array('superadmin', 'guest')
            )
        ));

        $this->assertEquals(array('member', 'editor'), $controllerGuard->getAllowedRolesByControllerAction('index', 'update'));
        $this->assertEquals(array('superadmin', 'guest'), $controllerGuard->getAllowedRolesByControllerAction('foo', 'bar'));
    }
}
