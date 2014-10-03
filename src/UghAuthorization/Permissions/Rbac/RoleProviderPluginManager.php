<?php

namespace UghAuthorization\Permissions\Rbac;

use RuntimeException;
use Zend\ServiceManager\AbstractPluginManager;

class RoleProviderPluginManager extends AbstractPluginManager
{

    /** @var array */
    protected $invokableClasses = array(
        'UghAuthorization\Permissions\Rbac\RoleProvider' => 'UghAuthorization\Permissions\Rbac\ConfigFileRoleProvider'
    );

    /**
     * 
     * @param RoleProvider $plugin
     * @throws RuntimeException
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof RoleProvider) {
            throw new RuntimeException(sprintf('Role provider must implement "UghAuthorization\Permissions\Rbac\RoleProvider", but "%s" was given', is_object($plugin) ? get_class($plugin) : gettype($plugin)));
        }
    }

    /**
     * 
     * @param string $name
     * @return string
     */
    protected function canonicalizeName($name)
    {
        return $name;
    }
}
