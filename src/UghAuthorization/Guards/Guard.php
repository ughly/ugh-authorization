<?php

namespace UghAuthorization\Guards;

interface Guard
{

    /**
     * 
     * @param mixed $permission
     */
    public function isGranted($permission);
}
