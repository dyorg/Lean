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
	
	public static function format($hour, $format)
	{
		if($format == self::FORMAT_HOUR_MINUTES)
		{
			$hour_slices = explode(':', $hour);
			$h = isset($hour_slices[0]) ? $hour_slices[0] : '00';
			$m = isset($hour_slices[1]) ? $hour_slices[1] : '00';
			return "$h:$m";
		}
		
		if($format == self::FORMAT_HOUR_MINUTES_SECONDS)
		{
			$hour_slices = explode(':', $hour);
			$h = isset($hour_slices[0]) ? $hour_slices[0] : '00';
			$m = isset($hour_slices[1]) ? $hour_slices[1] : '00';
			$s = isset($hour_slices[2]) ? $hour_slices[2] : '00';
			return "$h:$m:$s";
		}
		
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
}