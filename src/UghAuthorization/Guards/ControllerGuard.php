<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;

class ControllerGuard implements Guard
{

    /** @var AuthorizationService */
    private $authorizationService;
    private $rules;

    public function __construct(AuthorizationService $authorizationService, array $rules)
    {
        $this->authorizationService = $authorizationService;
        $this->rules = $rules;
    }

    public function isGranted($permission)
    {
        $controllerName = $permission['controller'];
        $actionName = $permission['action'];

        if (!$this->isControllerActionGuarded($controllerName, $actionName)) {
            return true;
        }

        $allowedRoles = $this->getAllowedRolesByControllerAction($controllerName, $actionName);

        return $this->authorizationService->matchIdentityRoles($allowedRoles);
    }

    public function isControllerActionGuarded($controllerName, $actionName)
    {
        $ruleMatches = $this->matchRuleByControllerAction($controllerName, $actionName);
        return !empty($ruleMatches);
    }

    public function getAllowedRolesByControllerAction($controllerName, $actionName)
    {
        $allowedRoles = array();

        $ruleMatches = $this->matchRuleByControllerAction($controllerName, $actionName);

        foreach ($ruleMatches as $rule) {
            $allowedRoles = array_merge($allowedRoles, $rule['roles']);
        }

        return $allowedRoles;
    }

    public function matchRuleByControllerAction($controllerName, $actionName)
    {
        $matches = array();

        foreach ($this->rules as $controller) {
            if ($controller['controller'] == $controllerName &&
                    in_array($actionName, $controller['actions'])) {
                $matches[] = $controller;
            }
        }

        return $matches;
    }
}
