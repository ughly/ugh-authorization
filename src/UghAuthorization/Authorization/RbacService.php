<?php

namespace UghAuthorization\Authorization;

use Zend\Permissions\Rbac\Rbac;

class RbacService implements AuthorizationService
{

    /** @var Rbac */
    private $rbac;

    /** @var array */
    private $identityRoles;

    /**
     * 
     * @param Rbac $rbac
     * @param array $identityRoles
     */
    public function __construct(Rbac $rbac, array $identityRoles)
    {
        $this->rbac = $rbac;
        $this->identityRoles = $identityRoles;
    }

    /**
     * 
     * @param mixed $permission
     * @return boolean
     */
    public function isGranted($permission)
    {
        if (!$this->identityRoles) {
            return false;
        }

        $isGranted = false;

        foreach ($this->identityRoles as $role) {
            if ($this->rbac->isGranted($role, $permission)) {
                $isGranted = true;
                break;
            }
        }

        return $isGranted;
    }

    /**
     * 
     * @param array $roles
     * @return boolean
     */
    public function matchIdentityRoles(array $roles)
    {
        $matches = array_intersect($this->identityRoles, $roles);
        return !empty($matches);
    }
}
