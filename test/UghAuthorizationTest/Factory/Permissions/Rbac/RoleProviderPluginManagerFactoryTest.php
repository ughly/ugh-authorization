<?php

namespace UghAuthorizationTest\Factory\Permissions\Rbac;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Permissions\Rbac\RoleProviderPluginManagerFactory;
use Zend\ServiceManager\ServiceManager;

class RoleProviderPluginManagerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $serviceManager = new ServiceManager();

        $factory = new RoleProviderPluginManagerFactory();

        $roleProviderPluginManager = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Permissions\Rbac\RoleProviderPluginManager', $roleProviderPluginManager);
    }
}
