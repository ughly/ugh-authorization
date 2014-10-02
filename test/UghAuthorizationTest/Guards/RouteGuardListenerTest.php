<?php

namespace UghAuthorizationTest\Guards;

use PHPUnit_Framework_TestCase;
use UghAuthorization\Guards\RouteGuardListener;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Model\ViewModel;

class RouteGuardListenerTest extends PHPUnit_Framework_TestCase
{

    public function testCanAttachEvent()
    {
        $routeGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard')->disableOriginalConstructor()->getMock();

        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->once())->method('attach')->with(MvcEvent::EVENT_ROUTE);

        $guard = new RouteGuardListener($routeGuardMock);

        $guard->attach($eventManager);
    }

    public function testCanTriggerForbiddenEvent()
    {
        $eventManager = $this->getMock('Zend\EventManager\EventManagerInterface');
        $eventManager->expects($this->once())->method('trigger')->with(MvcEvent::EVENT_DISPATCH_ERROR);

        $application = $this->getMock('Zend\Mvc\Application', array(), array(), '', false);
        $application->expects($this->any())->method('getEventManager')->will($this->returnValue($eventManager));

        $routeMatch = new RouteMatch(array());
        $routeMatch->setMatchedRouteName('secure');

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $event->setApplication($application);

        $response = new Response();
        $event->setResponse($response);

        $routeGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard', array('isGranted', 'getErrorViewModel'))->disableOriginalConstructor()->getMock();
        $routeGuardMock->expects($this->any())->method('isGranted')->will($this->returnValue(false));

        $routeGuardListener = new RouteGuardListener($routeGuardMock);

        $routeGuardListener->setErrorViewModel(new ViewModel());

        $routeGuardListener->onGuard($event);

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
        $routeMatch->setMatchedRouteName('secure');

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);
        $event->setApplication($application);

        $routeGuardMock = $this->getMockBuilder('UghAuthorization\Guards\Guard', array('isGranted'))->disableOriginalConstructor()->getMock();
        $routeGuardMock->expects($this->any())->method('isGranted')->will($this->returnValue(true));

        $routeGuardListener = new RouteGuardListener($routeGuardMock);

        $routeGuardListener->onGuard($event);

        $this->assertFalse($event->propagationIsStopped());
        $this->assertEmpty($event->getError());
    }
}
