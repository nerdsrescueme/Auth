<?php

namespace Auth\Acl;

abstract class Driver implements AclInterface
{
    private $auth;

    public function __construct(\Auth\Auth $auth)
    {
        $this->auth = $auth;
    }
}
