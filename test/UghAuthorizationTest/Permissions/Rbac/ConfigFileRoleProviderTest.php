<?php

namespace UghAuthorizationTest\Permissions\Rbac;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Permissions\Rbac\ConfigFileRoleProvider;

class ConfigFileRoleProviderTest extends PHPUnit_Framework_TestCase
{

    public function testCanGetRoles()
    {
        $rolesPermissions = new ConfigFileRoleProvider(array(
            'admin' => array(
                'children' => array('editor'),
                'permissions' => array('page.delete')
            ),
            'editor' => array(
                'children' => array('guest'),
                'permissions' => array('page.create', 'page.update')
            ),
            'guest' => array(
                'permissions' => array('page.retrieve')
            )
        ));

        $roles = $rolesPermissions->getRoles(array('admin', 'editor', 'guest'));

        $this->assertTrue(is_array($roles));

        $this->assertCount(3, $roles);

        $adminRole = $roles[0];
        $this->assertEquals('admin', $adminRole->getName());
        $this->assertTrue($adminRole->hasChildren());
        $this->assertTrue($adminRole->hasPermission('page.delete'));
        $this->assertTrue($adminRole->hasPermission('page.create'));
        $this->assertTrue($adminRole->hasPermission('page.update'));

        $editorRole = $roles[1];
        $this->assertEquals('editor', $editorRole->getName());
        $this->assertTrue($editorRole->hasChildren());
        $this->assertTrue($editorRole->hasPermission('page.create'));
        $this->assertTrue($editorRole->hasPermission('page.update'));
        $this->assertFalse($editorRole->hasPermission('page.delete'));

        $guestRole = $roles[2];
        $this->assertEquals('guest', $guestRole->getName());
        $this->assertFalse($guestRole->hasChildren());
        $this->assertTrue($guestRole->hasPermission('page.retrieve'));
        $this->assertFalse($guestRole->hasPermission('page.create'));
        $this->assertFalse($guestRole->hasPermission('page.delete'));
    }

    public function testCanCreateDefaultRole()
    {
        $rolesPermissions = new ConfigFileRoleProvider(array());

        $roles = $rolesPermissions->getRoles(array('anonymous'));

        $this->assertTrue(is_array($roles));

        $this->assertCount(1, $roles);
    }
}
