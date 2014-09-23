<?php

namespace UghAuthorizationTest\Options;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Options\ModuleOptions;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{

    public function testCanLoadOptions()
    {
        $moduleOptions = new ModuleOptions(array(
            'identity_provider' => 'IdentityProvider',
            'role_provider' => array('RoleProvider'),
            'route_guards' => array('RouteGuards'),
            'controller_guards' => array('ControllerGuards'),
            'guard_listeners' => array('UghAuthorization\Guards\RouteGuardListener', 'UghAuthorization\Guards\ControllerGuardListener')
        ));

        $this->assertEquals('IdentityProvider', $moduleOptions->getIdentityProvider());
        $this->assertEquals(array('RoleProvider'), $moduleOptions->getRoleProvider());
        $this->assertEquals(array('RouteGuards'), $moduleOptions->getRouteGuards());
        $this->assertEquals(array('ControllerGuards'), $moduleOptions->getControllerGuards());
        $this->assertEquals(array('UghAuthorization\Guards\RouteGuardListener', 'UghAuthorization\Guards\ControllerGuardListener'), $moduleOptions->getGuardListeners());
    }
}
