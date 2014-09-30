<?php

namespace UghAuthorization\Guards;

use UghAuthorization\Authorization\AuthorizationService;

class ControllerGuard implements Guard
{

    /** @var AuthorizationService */
    private $authorizationService;
    private $rules;
    private $errorView;

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
            if (fnmatch($controller['controller'], $controllerName) && $this->isActionNameInArray($actionName, $controller['actions'])) {
                $matches[] = $controller;
            }
        }

        return $matches;
    }

    public function isActionNameInArray($actionName, $array)
    {
        $flag = false;

        foreach ($array as $item) {
            if (fnmatch($item, $actionName)) {
                $flag = true;
            }
        }

        return $flag;
    }

    public function setErrorViewModel($viewModel)
    {
        $this->errorView = $viewModel;
    }

    public function getErrorViewModel()
    {
        if (!isset($this->errorView)) {
            $this->errorView = new ViewModel();
        }
        return $this->errorView;
    }
}
