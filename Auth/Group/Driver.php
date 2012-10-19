<?php

namespace Auth\Group;

abstract class Driver implements GroupInterface
{
    private $auth;

    public function __construct(\Auth\Auth $auth)
    {
        $this->auth = $auth;
    }
}
