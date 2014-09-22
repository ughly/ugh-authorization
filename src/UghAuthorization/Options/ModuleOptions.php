<?php

namespace UghAuthorization\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    protected $identityProvider;
    protected $roleProvider;
    protected $routeGuards;
    protected $controllerGuards;

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function getRoleProvider()
    {
        return $this->roleProvider;
    }

    public function getRouteGuards()
    {
        return $this->routeGuards;
    }

    public function getControllerGuards()
    {
        return $this->controllerGuards;
    }

    public function setRoleProvider($roleProvider)
    {
        $this->roleProvider = $roleProvider;
    }

    public function setRouteGuards($routeGuards)
    {
        $this->routeGuards = $routeGuards;
    }

    public function setControllerGuards($controllerGuards)
    {
        $this->controllerGuards = $controllerGuards;
    }

    public function getIdentityProvider()
    {
        return $this->identityProvider;
    }

    public function setIdentityProvider($identityProvider)
    {
        $this->identityProvider = $identityProvider;
    }
}
