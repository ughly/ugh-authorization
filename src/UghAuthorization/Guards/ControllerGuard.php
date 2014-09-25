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

        $allowedRoles = $this->getAllowedRolesByControllerAction($controllerName, $actionName);

        return $this->authorizationService->matchIdentityRoles($allowedRoles);
    }

    public function getAllowedRolesByControllerAction($controllerName, $actionName)
    {
        $allowedRoles = array();

        foreach ($this->rules as $controller) {
            if ($controller['controller'] == $controllerName &&
                    in_array($actionName, $controller['actions'])) {
                $allowedRoles = array_merge($allowedRoles, $controller['roles']);
            }
        }

        return $allowedRoles;
    }
}
