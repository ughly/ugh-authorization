<?php

namespace UghAuthorization\Identity;

interface IdentityProvider
{

    /**
     * @return Identity
     */
    public function getIdentity();
}
