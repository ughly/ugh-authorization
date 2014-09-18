<?php

namespace UghAuthorizationTest\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Guards\ControllerGuardListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class ControllerGuardListenerTest extends PHPUnit_Framework_TestCase
{

    public function testCanAttachEvent()
    {
        $controllerGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard')->disableOriginalConstructor()->getMock();

        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->once())->method('attach')->with(MvcEvent::EVENT_ROUTE);

        $guard = new ControllerGuardListener($controllerGuardMock);

        $guard->attach($eventManager);
    }

    public function testCanTriggerForbiddenEvent()
    {
        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->once())->method('trigger')->with(MvcEvent::EVENT_DISPATCH_ERROR);

        $application = $this->getMock('Zend\Mvc\Application', array(), array(), '', false);
        $application->expects($this->any())->method('getEventManager')->will($this->returnValue($eventManager));

        $routeMatch = new RouteMatch(array());
        $routeMatch->setParam("controller", "index");
        $routeMatch->setParam("action", "update");

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $event->setApplication($application);

        $controllerGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard', array('isGranted'))->disableOriginalConstructor()->getMock();
        $controllerGuardMock->expects($this->any())->method('isGranted')->will($this->returnValue(false));

        $controllerGuardListener = new ControllerGuardListener($controllerGuardMock);

        $controllerGuardListener->onGuard($event);

        $this->assertTrue($event->propagationIsStopped());
        $this->assertEquals('route-forbidden', $event->getError());
    }

    public function testCanAllowAccess()
    {
        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->never())->method('trigger');

        $application = $this->getMock('Zend\Mvc\Application', array(), array(), '', false);
        $application->expects($this->any())->method('getEventManager')->will($this->returnValue($eventManager));

        $routeMatch = new RouteMatch(array());
        $routeMatch->setParam("controller", "index");
        $routeMatch->setParam("action", "update");

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $event->setApplication($application);

        $controllerGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard', array('isGranted'))->disableOriginalConstructor()->getMock();
        $controllerGuardMock->expects($this->any())->method('isGranted')->will($this->returnValue(true));

        $controllerGuardListener = new ControllerGuardListener($controllerGuardMock);

        $controllerGuardListener->onGuard($event);

        $this->assertFalse($event->propagationIsStopped());
        $this->assertEmpty($event->getError());
    }
}
