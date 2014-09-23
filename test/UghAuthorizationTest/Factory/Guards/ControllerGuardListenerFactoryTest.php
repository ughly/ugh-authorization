<?php

namespace UghAuthorizationTest\Factory\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Guards\ControllerGuardListenerFactory;
use Zend\ServiceManager\ServiceManager;

class ControllerGuardListenerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $controllerGuardMock = $this->getMockBuilder('UghAuthorization\Guards\ControllerGuard')->disableOriginalConstructor()->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Guards\ControllerGuard', $controllerGuardMock);

        $factory = new ControllerGuardListenerFactory();

        $controllerGuardListener = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Guards\ControllerGuardListener', $controllerGuardListener);
    }
}
