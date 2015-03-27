<?php
namespace Lean\Format;

class Date extends \Lean\Singleton
{
	static private $instance;

	/**
	 * @var string Formatos para conversão
	 */
	const FORMAT_DATE = '%Y-%m-%d';
	const FORMAT_DATE_TIME = '%Y-%m-%d %H:%M:%S';
	const FORMAT_DATE_USER = '%d/%m/%Y';
	const FORMAT_DATE_TIME_USER = '%d/%m/%Y %H:%M:%S';
	const FORMAT_DATE_LONG = '%A, %d de %B de %Y';
	const FORMAT_DAY = '%d';
	const FORMAT_MONTH = '%m';
	const FORMAT_YEAR = '%Y';
	const FORMAT_TIME = '%H:%M:%S';
	const FORMAT_TIME_SHORT = '%H:%M';
	const FORMAT_DATE_TIME_HASH = '%Y%m%d_%H%M%S';

	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self();

		return self::$instance;
	}

	public static function format($date, $format)
	{
		return strftime($format, strtotime($date));
	}
	
	public static function format_to_human($date, $format = null)
	{				
		if ( substr($date, 0, 10) == '0000-00-00' || empty($date)) return '';

		if (!is_null($format)) return strftime($format, strtotime($date));

		if (strlen($date) <= 10)
			return strftime(self::FORMAT_DATE_USER, strtotime($date));
		else
			return strftime(self::FORMAT_DATE_TIME_USER, strtotime($date));
	}

	public static function format_to_machine($date, $format = null)
	{
		if (self::validateFormatDatabase($date)) return $date;

		if ($date == '' || empty($date)) return '0000-00-00';
		
		$date_valid_user = self::validateUser($date);

		if ($date_valid_user)
		{
			$slices = explode('-', $date_valid_user);
			
			if (!is_null($format)) 	return strftime($format, mktime(0,0,0, $slices[1],$slices[0], $slices[2]));
			
			return strftime(self::FORMAT_DATE, mktime(0,0,0, $slices[1],$slices[0], $slices[2]));
 		}
 		else
 		{
 			if (!is_null($format)) return strftime($format, strtotime($date));
 			
 			return strftime(self::FORMAT_DATE, strtotime($date));
 		}
	}

	public static function now($format = self::FORMAT_DATE_TIME)
	{
		return strftime($format);
	}

	/**
	 * @deprecated
	 * @see Date::validate_format_human
	 */
	public static function validateUser($date)
	{
		if (empty($date)) return false;

		$date = str_replace('/', '-', $date);
		$slices = explode('-', $date);

		if (!isset($slices[0])) return false;
		if (!isset($slices[1])) return false;
		if (!isset($slices[2])) return false;

		if(checkdate($slices[1], $slices[0], $slices[2]))
		{
			return $date;
		}
		else
		{
			return false;
		}
	}
	
	public static function validate_format_human($date)
	{
		$date = str_replace('/', '-', $date);
		
		if(!preg_match('/^([0-9]{2})-([0-9]{2})-([0-9]{2,4})/', $date, $matches)) return false;
		
		if(!isset($matches[1]) || !isset($matches[2]) || !isset($matches[3]) ) return false;
		
		if(!checkdate($matches[2], $matches[1], $matches[3])) return false;
			
		return true;
	}
	
	public static function validate_format_machine($date)
	{
		if(!preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})/', $date, $matches)) return false;
	
		if(!isset($matches[1]) || !isset($matches[2]) || !isset($matches[3]) ) return false;
	
		if(!checkdate($matches[2], $matches[3], $matches[1])) return false;
			
		return true;
	}

	/**
	 * @deprecated
	 * @see Date::validate_format_machine
	 */
	public static function validateFormatDatabase($date)
	{
		return preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}/', $date);
	}
	
	public static function validate($date)
	{
		if(self::validate_format_machine($date)) return true;
		
		if(self::validate_format_human($date)) return true;
		
		return false;
	}
}