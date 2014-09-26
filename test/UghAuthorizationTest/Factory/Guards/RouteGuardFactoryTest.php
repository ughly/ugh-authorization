<?php

namespace UghAuthorizationTest\Factory\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Guards\RouteGuardFactory;
use Zend\ServiceManager\ServiceManager;

class RouteGuardFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $testArray = array(
            'secure' => array('member')
        );

        $authorizationProvderMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('matchIdentityRoles'))->disableOriginalConstructor()->getMock();
        $authorizationProvderMock->expects($this->once())->method('matchIdentityRoles')->will($this->returnValue(true));

        $moduleOptionsMock = $this->getMockBuilder('UghAuthorization\Options\ModuleOptions', array('getRouteGuards'))->disableOriginalConstructor()->getMock();
        $moduleOptionsMock->expects($this->once())->method('getRouteGuards')->will($this->returnValue($testArray));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Options\ModuleOptions', $moduleOptionsMock);
        $serviceManager->setService('UghAuthorization\Authorization\AuthorizationService', $authorizationProvderMock);

        $factory = new RouteGuardFactory();

        $routeGuard = $factory->createService($serviceManager);

        $this->assertTrue($routeGuard->isGranted('secure'));
        $this->assertInstanceOf('UghAuthorization\Guards\RouteGuard', $routeGuard);
    }
}
