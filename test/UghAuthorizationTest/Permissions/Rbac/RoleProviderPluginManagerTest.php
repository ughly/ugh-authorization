<?php

namespace UghAuthorizationTest\Permissions\Rbac;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Permissions\Rbac\RoleProviderPluginManager;

class RoleProviderPluginManagerTest extends PHPUnit_Framework_TestCase
{

    public function testRoleProviderPluginManagerValidation()
    {
        $pluginMock = $this->getMock('UghAuthorization\Permissions\Rbac\RoleProvider');

        $pluginManager = new RoleProviderPluginManager();

        $this->assertNull($pluginManager->validatePlugin($pluginMock));
    }

    public function testRoleProviderPluginManagerValidationThrowsException()
    {
        $this->setExpectedException('\RuntimeException');

        $pluginManager = new RoleProviderPluginManager();

        $pluginManager->get('stdclass');
    }
}
