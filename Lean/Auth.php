<?php

class Myapp_Auth
{
	static $redirect;
	
	static $auth = true;
	
	static public function authenticate($password_user, $password_db)
	{
		if ($password_user == $password_db)
		{
			Myapp_Session::session()->setAttribute('AUTH_SESSION', 'YES');

			return true;
		}

		return false;
	}
	
	static public function isAuth()
	{
		if (self::$auth == false) return true;
		
		if (Myapp_Session::session()->getAttribute('AUTH_SESSION') === 'YES')
		{
			return true;
		}
		
		return false;
	}
	
	static public function discart()
	{
		Myapp_Session::session()->unsetAttribute('AUTH_SESSION');
		//Myapp_Session::session('AUTH_SESSION', 'NO');
		return true;
	}
}