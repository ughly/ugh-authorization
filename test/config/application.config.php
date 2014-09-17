<?php

return array(
    'modules' => array(
        'UghAuthorization'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './tests',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
            'tests/config/autoload/{,*.}{global,local}.php',
        )
    )
);