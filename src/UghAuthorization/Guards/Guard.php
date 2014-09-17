<?php

namespace UghAuthorization\Guards;

interface Guard
{

    public function isGranted($permission);
}
