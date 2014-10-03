<?php

namespace UghAuthorization\Permissions\Rbac;

interface RoleProvider
{

    /**
     * 
     * @param array $roleNames
     */
    public function getRoles(array $roleNames);
}
