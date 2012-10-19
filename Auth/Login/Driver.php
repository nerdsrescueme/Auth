<?php

namespace Auth\Login;

abstract class Driver implements LoginInterface
{
    private $auth;

    public function __construct(\Auth\Auth $auth)
    {
        $this->auth = $auth;
    }

    abstract public function login($identifier, $secret = '');

    abstract public function brute($identifier);

    abstract public function logout();
}
