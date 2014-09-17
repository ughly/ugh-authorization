<?php

namespace UghAuthorization\Authorization;

use Zend\Permissions\Rbac\Rbac;

class RbacService implements AuthorizationService
{

    private $rbac;
    private $identityRoles;
    
    public function __construct(Rbac $rbac, array $identityRoles)
    {
        $this->rbac = $rbac;
        $this->identityRoles = $identityRoles;
    }

    public function isGranted($permission)
    {
        if(!$this->identityRoles){
            return false;
        }
        
        $isGranted = false;
        
        foreach($this->identityRoles as $role){
            if($this->rbac->isGranted($role, $permission)){
                $isGranted = true;
                break;
            }
        }
        
        return $isGranted;
    }
    
    public function matchIdentityRoles(array $roles)
    {
        $matches = array_intersect($this->identityRoles, $roles);
        return !empty($matches);
    }

}
