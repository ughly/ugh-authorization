<?php

namespace UghAuthorization\Identity;

class AnonymousIdentity implements Identity
{

    /**
     * 
     * @return array
     */
    public function getRoles()
    {
        return array();
    }
}
