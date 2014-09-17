<?php

namespace UghAuthorization\Permissions\Rbac;

interface RoleProvider
{

    public function getRoles(array $roleNames);
}
