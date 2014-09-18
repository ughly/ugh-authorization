<?php

namespace UghAuthorization\Permissions\Rbac;

use Zend\Permissions\Rbac\Role;

class ConfigFileRoleProvider implements RoleProvider
{

    private $rolesConfig;

    public function __construct(array $rolesConfig)
    {
        $this->rolesConfig = $rolesConfig;
    }

    public function getRoles(array $roleNames)
    {
        $roles = array();

        foreach ($roleNames as $roleName) {
            if (!isset($this->rolesConfig[$roleName])) {
                $roles[] = new Role($roleName);
                continue;
            }

            $role = new Role($roleName);

            $roleConfig = $this->rolesConfig[$roleName];

            if (isset($roleConfig['children'])) {
                $childRoles = (array) $roleConfig['children'];
                foreach ($this->getRoles($childRoles) as $childRole) {
                    $role->addChild($childRole);
                }
            }

            $permissions = isset($roleConfig['permissions']) ? $roleConfig['permissions'] : array();
            foreach ($permissions as $permission) {
                $role->addPermission($permission);
            }

            $roles[] = $role;
        }

        return $roles;
    }
}
