<?php

namespace UghAuthorization\Identity;

use Zend\Authentication\AuthenticationServiceInterface;

class AuthenticationIdentityProvider implements IdentityProvider
{

    /** @var AuthenticationServiceInterface */
    private $authenticationService;

    /**
     * 
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @todo Remove the AnonymousIdentity instantiation. This belongs in an Authentication Adapter
     * @return Identity
     */
    public function getIdentity()
    {
        $identity = $this->authenticationService->getIdentity();
        if (is_null($identity)) {
            $identity = new AnonymousIdentity();
        }

        return $identity;
    }
}
