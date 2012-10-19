<?php

namespace Auth\Login\Driver;

class Simple extends \Auth\Login\Driver
{
	public function login($identifier, $secret = '')
	{
		return true;
	}

	public function brute($identifier)
	{
		return true;
	}

	public function logout()
	{
		return true;
	}
}