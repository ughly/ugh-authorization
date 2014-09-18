<?php

namespace UghAuthorizationTest\Options;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Options\ModuleOptions;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{

    public function testCanLoadOptions()
    {
        $moduleOptions = new ModuleOptions(array(
            'authentication_service' => 'AuthService',
            'role_provider' => array('RoleProvider'),
            'route_guards' => array('RouteGuards'),
            'controller_guards' => array('ControllerGuards')
        ));

        $this->assertEquals('AuthService', $moduleOptions->getAuthenticationService());
        $this->assertEquals(array('RoleProvider'), $moduleOptions->getRoleProvider());
        $this->assertEquals(array('RouteGuards'), $moduleOptions->getRouteGuards());
        $this->assertEquals(array('ControllerGuards'), $moduleOptions->getControllerGuards());
    }
}
