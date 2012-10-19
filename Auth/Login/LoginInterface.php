<?php

namespace Auth\Login;

interface LoginInterface
{
    public function login($identifier, $secret = '');
}
