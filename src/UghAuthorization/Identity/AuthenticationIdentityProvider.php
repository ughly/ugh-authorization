<?php

namespace UghAuthorization\Identity;

use Zend\Authentication\AuthenticationServiceInterface;

class AuthenticationIdentityProvider implements IdentityProvider
{

    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getIdentity()
    {
        $identity = $this->authenticationService->getIdentity();
        if (is_null($identity)) {
            $identity = new AnonymousIdentity();
        }

        return $identity;
    }
}
