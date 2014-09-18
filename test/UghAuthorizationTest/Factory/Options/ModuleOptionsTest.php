<?php

namespace UghAuthorizationTest\Factory\Options;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Options\ModuleOptionsFactory;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', array(
            'ugh_authorization' => array()
        ));

        $factory = new ModuleOptionsFactory();
        $moduleOptions = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Options\ModuleOptions', $moduleOptions);
    }
}
