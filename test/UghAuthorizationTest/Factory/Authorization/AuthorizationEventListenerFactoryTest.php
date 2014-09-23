<?php

namespace UghAuthorizationTest\Factory\Authorization;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Factory\Authorization\AuthorizationEventListenerFactory;
use Zend\ServiceManager\ServiceManager;

class AuthorizationEventListenerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCanCreateService()
    {
        $authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array())->disableOriginalConstructor()->getMock();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('UghAuthorization\Authorization\AuthorizationService', $authorizationServiceMock);

        $factory = new AuthorizationEventListenerFactory();
        $authorizationEventListener = $factory->createService($serviceManager);

        $this->assertInstanceOf('UghAuthorization\Authorization\AuthorizationEventListener', $authorizationEventListener);
    }
}
