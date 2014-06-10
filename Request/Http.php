<?php
namespace Lean\Request;

class Http extends \Lean\Singleton
{
	static protected $http_variable;

	public function __construct($http_variable = null)
	{
		foreach ($http_variable as $key => $value)
		{
			$this->{$key} = $value;
		}
	}

	public function decode($to = 'ISO-8859-1', $from = 'UTF-8')
	{
		foreach ($this as $key => $value)
		{
			$this->$key = mb_convert_encoding($value, $to, $from);
		}

		return $this;
	}
}