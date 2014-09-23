<?php

return array(
    'services' => array(
        'factories' => array(
            'UghAuthorization\Options\ModuleOptions' => 'UghAuthorization\Factory\Options\ModuleOptionsFactory',
            'UghAuthorization\Permissions\Rbac\Rbac' => 'UghAuthorization\Factory\Permissions\Rbac\RbacFactory'
        )
    )
);
