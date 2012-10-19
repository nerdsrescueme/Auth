<?php

namespace Auth;

use Nerd\Crypt
  , Nerd\Config
  , Nerd\Arr
  , Nerd\Cookie;

class Auth
{
	private $crypt;
	private $acl;
	private $group;
	private $login;

	private $validated;

	public function __construct($driver = 'simple')
	{
		$this->crypt  = Crypt::instance(Config::get('auth::auth.crypt', 'xcrypt'));

		$login = $this->_locateDriver('login', $driver);
		$group = $this->_locateDriver('group', $driver);
		$acl   = $this->_locateDriver('acl', $driver);

		try {
			$this->login = new $login($this);
			$this->group = new $group($this);
			$this->acl   = new $acl($this);
		} catch (\Exception $e) {
			throw new Exception($e->getMessage(), $e->getCode(), $e);
		}
	}

	public function login($identifier, $secret = '')
	{
		$this->validated = $this->login->login($identifier, $secret = '');
		return $this->in;
	}

	public function logout()
	{
		$this->validated = $this->login->logout();
		return !$this->validated;
	}

	public function brute($identifier)
	{
		$this->validated = $this->login->brute($identifier);
		return $this->validated;
	}

	public function cookie()
	{
		
	}

	private function _locateDriver($type, $driver)
	{
		if (strpos($driver, '\\') !== false)
		{
			return $driver;
		}

		return '\\Auth\\'.ucfirst($type).'\\Driver\\'.ucfirst($driver);
	}
}