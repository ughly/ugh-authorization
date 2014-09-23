<?php

return array(
    'services' => array(
        'factories' => array(
            'UghAuthorization\Options\ModuleOptions' => 'UghAuthorization\Factory\Options\ModuleOptionsFactory',
            'UghAuthorization\Permissions\Rbac\Rbac' => 'UghAuthorization\Factory\Permissions\Rbac\RbacFactory',
            'UghAuthorization\Guards\RouteGuard' => 'UghAuthorization\Factory\Guards\RouteGuardFactory',
            'UghAuthorization\Guards\RouteGuardListener' => 'UghAuthorization\Factory\Guards\RouteGuardListenerFactory',
            'UghAuthorization\Authorization\AuthorizationEventListener' => 'UghAuthorization\Factory\Authorization\AuthorizationEventListenerFactory'
        )
    )
);
