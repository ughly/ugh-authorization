<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\UnauthorizedException;
use UghAuthorization\Guards\Guard;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

abstract class GuardListener extends AbstractListenerAggregate
{

    /** @var Guard */
    protected $guard;
    protected $errorView;

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
        $event->setParam('exception', new UnauthorizedException('You are forbidden!', 403));

        $event->stopPropagation(true);

        $event->setViewModel($this->getErrorViewModel());

        $response = $event->getResponse();
        $response->setStatusCode(403);
        $event->setResponse($response);

        $application = $event->getApplication();
        $eventManager = $application->getEventManager();

        $eventManager->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

    public function setErrorViewModel($viewModel)
    {
        $this->errorView = $viewModel;
    }

    public function getErrorViewModel()
    {
        if (!isset($this->errorView)) {
            $this->errorView = new ViewModel();
        }
        return $this->errorView;
    }
}
