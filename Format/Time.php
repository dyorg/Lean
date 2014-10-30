<?php
namespace Lean\Format;

class Time extends \Lean\Singleton
{
	static private $instance;
	
	const FORMAT_HOUR_MINUTES = '%H:%M';
	
	const FORMAT_HOUR_MINUTES_SECONDS = '%H:%M:%S';
	
	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;
	
		return self::$instance;
	}
	
	public static function format($hour, $format = self::FORMAT_HOUR_MINUTES_SECONDS)
	{
				
		/* tratamento de horas, minutos e segundos */
		list ($h, $m, $s) = array_pad( explode(':', $hour), 3, '00');   
		$h = ( !is_numeric($h) ) ? '00' : str_pad($h , 2, '0');
		$m = !is_numeric($m) ? '00' : ( $m > 59 ? '59' : str_pad($m , 2, '0') );
		$s = !is_numeric($s) ? '00' : ( $s > 59 ? '59' : str_pad($s , 2, '0') );
		
		
		if ($format == self::FORMAT_HOUR_MINUTES) return "$h:$m";
		
		if ($format == self::FORMAT_HOUR_MINUTES_SECONDS) return "$h:$m:$s";
		
		return strftime($format, strtotime($hour));
	}
	
	public static function now()
	{
		return date('H:i:s');
	}

	public static function time_to_seconds($time) {
		$hours = substr($time, 0, -6);
		$minutes = substr($time, -5, 2);
		$seconds = substr($time, -2);

		return $hours * 3600 + $minutes * 60 + $seconds;
	}

	public static function seconds_to_time($seconds) {
		$hours = floor($seconds / 3600);
		$minutes = floor($seconds % 3600 / 60);
		$seconds = $seconds % 60;

		return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
	}

	public static function sum($time1, $time2, $op = 'add')
	{
		$now = new \DateTime(Date::now(Date::FORMAT_DATE));
		if ($op != 'add') $op == 'sub';
	
		$time1_slices = explode(':', $time1);
		$time1_hour = isset($time1_slices[0]) ? (int) $time1_slices[0] : '00';
		$time1_min	= isset($time1_slices[1]) ? (int) $time1_slices[1] : '00';
		$time1_sec 	= isset($time1_slices[2]) ? (int) $time1_slices[2] : '00';
	
		$time2_slices = explode(':', $time2);
		$time2_hour = isset($time2_slices[0]) ? (int) $time2_slices[0] : '00';
		$time2_min 	= isset($time2_slices[1]) ? (int) $time2_slices[1] : '00';
		$time2_sec 	= isset($time2_slices[2]) ? (int) $time2_slices[2] : '00';
	
		$now->add(new \DateInterval("PT{$time1_hour}H{$time1_min}M{$time1_sec}S"));
		$now->{$op}(new \DateInterval("PT{$time2_hour}H{$time2_min}M{$time2_sec}S"));
		$time = $now->format('H:i:s');
	
		return $time;
	
	}
	
	public static function subtract($time1, $time2) {
		return self::sum($time1, $time2, 'sub');
	}
}