<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;
use Zend\View\Model\ViewModel;

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
        if (!$this->isRouteGuarded($routeName)) {
            return true;
        }

        $allowedRoles = $this->getAllowedRolesByRouteName($routeName);

        return $this->authorizationService->matchIdentityRoles($allowedRoles);
    }

    public function isRouteGuarded($routeName)
    {
        $ruleMatches = $this->matchRuleByRouteName($routeName);
        return !empty($ruleMatches);
    }

    public function getAllowedRolesByRouteName($routeName)
    {
        $allowedRoles = array();

        $ruleMatches = $this->matchRuleByRouteName($routeName);

        foreach ($ruleMatches as $roles) {
            $allowedRoles = array_merge($allowedRoles, $roles);
        }

        return $allowedRoles;
    }

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
