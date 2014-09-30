<?php

namespace UghAuthorization\Guards;

interface Guard
{

    public function isGranted($permission);

    public function setErrorViewModel($viewModel);

    public function getErrorViewModel();
}
