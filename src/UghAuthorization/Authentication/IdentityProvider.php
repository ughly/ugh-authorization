<?php

namespace UghAuthorization\Authentication;

interface IdentityProvider
{

    /**
     * @return array
     */
    public function getRoles();
}
