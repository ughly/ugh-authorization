<?php

namespace UghAuthorization\Guards;

use Exception;
use UghAuthorization\Guards\Guard;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

abstract class GuardListener extends AbstractListenerAggregate
{

    /** @var Guard */
    protected $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function attach(EventManagerInterface $events)
    {
        $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onGuard'));
    }

    abstract public function onGuard(MvcEvent $event);


    protected function triggerForbiddenEvent(MvcEvent $event)
    {
        $event->setError('route-forbidden');
        $event->setParam('exception', new Exception('You are forbidden!', 403));

        $event->stopPropagation(true);

        $application = $event->getApplication();
        $eventManager = $application->getEventManager();

        $eventManager->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }
}
