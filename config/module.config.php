<?php

return array(
    'ugh_authorization' => array(
        'identity_provider' => 'UghAuthorization\Identity\AuthenticationIdentityProvider',
        'role_provider' => array(
            'UghAuthorization\Permissions\Rbac\RoleProvider' => array(
                array()
            )
        ),
        'route_guards' => array(),
        'controller_guards' => array(),
        'guard_listeners' => array(
            'UghAuthorization\Guards\RouteGuardListener',
            'UghAuthorization\Guards\ControllerGuardListener'
        ),
        'unauthorized_view_script' => 'error/403'
    ),
    'service_manager' => array(
        'factories' => array(
            'UghAuthorization\Authorization\AuthorizationService' => 'UghAuthorization\Factory\Authorization\RbacServiceFactory',
            'UghAuthorization\Permissions\Rbac\RoleProviderPluginManager' => 'UghAuthorization\Factory\Permissions\Rbac\RoleProviderPluginManagerFactory',
            'UghAuthorization\Identity\AuthenticationIdentityProvider' => 'UghAuthorization\Factory\Identity\AuthenticationIdentityProviderFactory',
            'UghAuthorization\Options\ModuleOptions' => 'UghAuthorization\Factory\Options\ModuleOptionsFactory',
            'UghAuthorization\Permissions\Rbac\Rbac' => 'UghAuthorization\Factory\Permissions\Rbac\RbacFactory',
            'UghAuthorization\Guards\RouteGuard' => 'UghAuthorization\Factory\Guards\RouteGuardFactory',
            'UghAuthorization\Guards\RouteGuardListener' => 'UghAuthorization\Factory\Guards\RouteGuardListenerFactory',
            'UghAuthorization\Guards\ControllerGuard' => 'UghAuthorization\Factory\Guards\ControllerGuardFactory',
            'UghAuthorization\Guards\ControllerGuardListener' => 'UghAuthorization\Factory\Guards\ControllerGuardListenerFactory',
            'UghAuthorization\Authorization\AuthorizationEventListener' => 'UghAuthorization\Factory\Authorization\AuthorizationEventListenerFactory'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        )
    )
);
