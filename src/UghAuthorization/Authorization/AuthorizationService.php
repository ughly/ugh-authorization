<?php

namespace UghAuthorization\Authorization;

interface AuthorizationService
{
    public function isGranted($permission);
    public function matchIdentityRoles(array $roles);
}
