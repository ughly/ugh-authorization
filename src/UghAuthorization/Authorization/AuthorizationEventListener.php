<?php

namespace UghAuthorization\Authorization;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

class AuthorizationEventListener extends AbstractListenerAggregate
{

    /** @var AuthorizationService */
    private $authorizationService;

    /**
     * 
     * @param AuthorizationService $authorizationService
     */
    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    /**
     * 
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events->getSharedManager()->attach('*', 'authorization.check', array($this, 'onCheck'));
    }

    /**
     * 
     * @param EventInterface $event
     * @throws UnauthorizedException
     */
    public function onCheck(EventInterface $event)
    {
        if (!$this->authorizationService->isGranted($event->getParam('permission'))) {
            throw new UnauthorizedException();
        }
    }
}
