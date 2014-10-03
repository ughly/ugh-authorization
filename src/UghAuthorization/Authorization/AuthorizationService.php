<?php

namespace UghAuthorization\Authorization;

interface AuthorizationService
{

    /**
     * 
     * @param mixed $permission
     */
    public function isGranted($permission);

    /**
     * 
     * @param array $roles
     */
    public function matchIdentityRoles(array $roles);
}
