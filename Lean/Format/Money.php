<?php
namespace Lean\Format;

class Money extends \Lean\Singleton
{
	static private $instance;
	
	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;
		
		return self::$instance;
	}
	
	public static function format_to_human($value)
	{			
		if (empty($value) || $value == '') return '0,00';

		return number_format($value, 2, ',', '.');
	}

	public static function format_to_machine($value)
	{
		/*
		 * se for tipo n�merico n�o � necess�rio formatar
		*/
		if (is_numeric($value)) return $value;

		if (empty($value)) return 0;

		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);

		return $value;
	}
}