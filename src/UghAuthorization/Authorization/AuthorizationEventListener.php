<?php

namespace UghAuthorization\Authorization;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

class AuthorizationEventListener extends AbstractListenerAggregate
{

    private $authorizationService;

    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    public function attach(EventManagerInterface $events)
    {
        $events->attach('authorization.check', array($this, 'onCheck'));
    }

    public function onCheck(EventInterface $event)
    {
        if (!$this->authorizationService->isGranted($event->getParam('permission'))) {
            throw new UnauthorizedException();
        }
    }
}
