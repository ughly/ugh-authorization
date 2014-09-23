<?php

namespace UghAuthorizationTest\Factory\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Guards\RouteGuardListenerFactory;
use Zend\ServiceManager\ServiceManager;

class RouteGuardListenerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $routeGuardMock = $this->getMockBuilder('UghAuthorization\Guards\RouteGuard')->disableOriginalConstructor()->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Guards\RouteGuard', $routeGuardMock);

        $factory = new RouteGuardListenerFactory();

        $routeGuardListener = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Guards\RouteGuardListener', $routeGuardListener);
    }
}
