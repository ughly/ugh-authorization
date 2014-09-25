<?php

namespace UghAuthorization\Permissions\Rbac;

use RuntimeException;
use Zend\ServiceManager\AbstractPluginManager;

class RoleProviderPluginManager extends AbstractPluginManager
{

    protected $invokableClasses = array(
        'UghAuthorization\Permissions\Rbac\RoleProvider' => 'UghAuthorization\Permissions\Rbac\ConfigFileRoleProvider'
    );

    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof RoleProvider) {
            throw new RuntimeException(sprintf('Role provider must implement "UghAuthorization\Permissions\Rbac\RoleProvider", but "%s" was given', is_object($plugin) ? get_class($plugin) : gettype($plugin)));
        }
    }

    protected function canonicalizeName($name)
    {
        return $name;
    }
}
