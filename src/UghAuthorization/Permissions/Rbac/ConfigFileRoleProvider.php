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
            $roles[] = $this->createRole($roleName);
        }

        return $roles;
    }

    private function createRole($roleName)
    {
        $role = new Role($roleName);

        $roleConfig = isset($this->rolesConfig[$roleName]) ? $this->rolesConfig[$roleName] : array();

        if (isset($roleConfig['children'])) {
            $childRoles = (array) $roleConfig['children'];
            $children = $this->getRoles($childRoles);
            foreach ($children as $child) {
                $role->addChild($child);
            }
        }

        if (isset($roleConfig['permissions'])) {
            $permissions = (array) $roleConfig['permissions'];
            foreach ($permissions as $permission) {
                $role->addPermission($permission);
            }
        }

        return $role;
    }
}
