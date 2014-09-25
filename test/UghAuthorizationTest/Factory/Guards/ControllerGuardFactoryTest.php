<?php

namespace UghAuthorizationTest\Factory\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Guards\ControllerGuardFactory;
use Zend\ServiceManager\ServiceManager;

class ControllerGuardFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $testArray = array(
            'controller' => 'index',
            'actions' => array('update', 'delete'),
            'roles' => array('member', 'editor')
        );
        $authorizationProviderMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('matchIdentityRoles'))->disableOriginalConstructor()->getMock();
        $authorizationProviderMock->expects($this->once())->method('matchIdentityRoles')->will($this->returnValue(true));

        $moduleOptionsMock = $this->getMockBuilder('UghAuthorization\Options\ModuleOptions', array('getControllerGuards'))->disableOriginalConstructor()->getMock();
        $moduleOptionsMock->expects($this->once())->method('getControllerGuards')->will($this->returnValue(array($testArray)));

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Options\ModuleOptions', $moduleOptionsMock);
        $serviceManager->setService('UghAuthorization\Authorization\AuthorizationService', $authorizationProviderMock);

        $factory = new ControllerGuardFactory();

        $controllerGuard = $factory->createService($serviceManager);

        $this->assertTrue($controllerGuard->isGranted(array('controller' => 'index', 'action' => 'update')));
        $this->assertInstanceOf('UghAuthorization\Guards\ControllerGuard', $controllerGuard);
    }
}
