<?php

namespace UghAuthorizationTest\Authorization;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Authorization\AuthorizationEventListener;
use Zend\EventManager\Event;

class AuthorizationEventListenerTest extends PHPUnit_Framework_TestCase
{

    public function testCanAttachEvent()
    {
        $authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('isGranted'))->disableOriginalConstructor()->getMock();

        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->once())->method('attach')->with('authorization.check');

        $listener = new AuthorizationEventListener($authorizationServiceMock);
        $listener->attach($eventManager);
    }

    public function testCanCheckAuthorization()
    {
        $authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('isGranted'))->disableOriginalConstructor()->getMock();
        $authorizationServiceMock->expects($this->once())->method('isGranted')->will($this->returnValue(true));

        $event = new Event('authorization.check', null, array('permission' => 'page.delete'));

        $listener = new AuthorizationEventListener($authorizationServiceMock);

        $listener->onCheck($event);
    }

    public function testCanThrowUnauthorizedException()
    {
        $this->setExpectedException('UghAuthorization\Authorization\UnauthorizedException');

        $authorizationServiceMock = $this->getMockBuilder('UghAuthorization\Authorization\AuthorizationService', array('isGranted'))->disableOriginalConstructor()->getMock();
        $authorizationServiceMock->expects($this->once())->method('isGranted')->will($this->returnValue(false));

        $event = new Event('authorization.check', null, array('permission' => 'page.delete'));

        $listener = new AuthorizationEventListener($authorizationServiceMock);

        $listener->onCheck($event);
    }
}
