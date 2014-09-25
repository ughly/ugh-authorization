<?php

namespace UghAuthorization\Identity;

class AnonymousIdentity implements Identity
{

    public function getRoles()
    {
        return array();
    }
}
