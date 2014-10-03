<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;

class RouteGuard implements Guard
{

    /** @var AuthorizationService */
    private $authorizationService;

    /** @var array */
    private $rules;

    /**
     * 
     * @param AuthorizationService $authorizationService
     * @param array $rules
     */
    public function __construct(AuthorizationService $authorizationService, array $rules)
    {
        $this->authorizationService = $authorizationService;
        $this->rules = $rules;
    }

    /**
     * 
     * @param string $routeName
     * @return boolean
     */
    public function isGranted($routeName)
    {
        if (!$this->isRouteGuarded($routeName)) {
            return true;
        }

        $allowedRoles = $this->getAllowedRolesByRouteName($routeName);

        return $this->authorizationService->matchIdentityRoles($allowedRoles);
    }

    /**
     * 
     * @param string $routeName
     * @return boolean
     */
    public function isRouteGuarded($routeName)
    {
        $ruleMatches = $this->matchRuleByRouteName($routeName);
        return !empty($ruleMatches);
    }

    /**
     * 
     * @param string $routeName
     * @return array
     */
    public function getAllowedRolesByRouteName($routeName)
    {
        $allowedRoles = array();

        $ruleMatches = $this->matchRuleByRouteName($routeName);

        foreach ($ruleMatches as $roles) {
            $allowedRoles = array_merge($allowedRoles, $roles);
        }

        return $allowedRoles;
    }

    /**
     * 
     * @param string $routeName
     * @return array
     */
    public function matchRuleByRouteName($routeName)
    {
        $matches = array();

        foreach ($this->rules as $route => $roles) {
            if (fnmatch($route, $routeName)) {
                $matches[$route] = $roles;
            }
        }

        return $matches;
    }
}
