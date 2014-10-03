<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;

class ControllerGuard implements Guard
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
     * @param mixed $permission
     * @return boolean
     */
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

    /**
     * 
     * @param string $controllerName
     * @param string $actionName
     * @return boolean
     */
    public function isControllerActionGuarded($controllerName, $actionName)
    {
        $ruleMatches = $this->matchRuleByControllerAction($controllerName, $actionName);
        return !empty($ruleMatches);
    }

    /**
     * 
     * @param string $controllerName
     * @param string $actionName
     * @return array
     */
    public function getAllowedRolesByControllerAction($controllerName, $actionName)
    {
        $allowedRoles = array();

        $ruleMatches = $this->matchRuleByControllerAction($controllerName, $actionName);

        foreach ($ruleMatches as $rule) {
            $allowedRoles = array_merge($allowedRoles, $rule['roles']);
        }

        return $allowedRoles;
    }

    /**
     * 
     * @param string $controllerName
     * @param string $actionName
     * @return array
     */
    public function matchRuleByControllerAction($controllerName, $actionName)
    {
        $matches = array();

        foreach ($this->rules as $controller) {
            if (fnmatch($controller['controller'], $controllerName) && $this->isActionNameInArray($actionName, $controller['actions'])) {
                $matches[] = $controller;
            }
        }

        return $matches;
    }

    /**
     * 
     * @param string $actionName
     * @param array $array
     * @return boolean
     */
    public function isActionNameInArray($actionName, array $array)
    {
        $flag = false;

        foreach ($array as $item) {
            if (fnmatch($item, $actionName)) {
                $flag = true;
            }
        }

        return $flag;
    }
}
