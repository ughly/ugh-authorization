<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;

class RouteGuard implements Guard
{
    /** @var AuthorizationService */
    private $authorizationService;
    
    private $rules;
    
    public function __construct(AuthorizationService $authorizationService, array $rules)
    {
        $this->authorizationService = $authorizationService;
        $this->rules = $rules;
    }
    
    public function isGranted($routeName)
    {
        $allowedRoles = $this->getAllowedRolesByRouteName($routeName);
        
        return $this->authorizationService->matchIdentityRoles($allowedRoles);
    }
    
    public function getAllowedRolesByRouteName($routeName)
    {
        $allowedRoles = array();
        
        foreach($this->rules as $route => $roles){
            if(fnmatch($route, $routeName)){
                $allowedRoles = array_merge($allowedRoles, $roles);
            }
        }
        
        return $allowedRoles;
    }
}
