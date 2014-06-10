<?php
namespace Lean;

class Logger extends Singleton
{
	static private $instance;
	
	public static function singleton()
	{
		if(!isset(self::$instance))	self::$instance = new self;
	
		return self::$instance;
	}
	
	public static function log_writer(\Exception $exception, $clear = false, $error_file = 'ex_log.html')
	{
		$message = $exception->getMessage();
		$code = $exception->getCode();
		$file = $exception->getFile();
		$line = $exception->getLine();
		$trace = $exception->getTraceAsString();
		$date = date('M d, Y h:iA');
			
		$log_message = "<h3>Exception information:</h3>
		<p>
		<strong>Date:</strong> {$date}
		</p>

		<p>
		<strong>Message:</strong> {$message}
		</p>
			
		<p>
		<strong>Code:</strong> {$code}
		</p>

		<p>
		<strong>File:</strong> {$file}
		</p>

		<p>
		<strong>Line:</strong> {$line}
		</p>

		<h3>Stack trace:</h3>
		<pre>{$trace}</pre>
		
		<h3>Request information:</h3>
		<pre>";
		foreach ($_REQUEST as $key => $value) {
			$log_message .= "<strong>$key</strong>: $value<br/>";
		}
		$log_message .= "</pre>";
		
		$log_message .= "<h3>Server information:</h3>
		<pre>";
		foreach ($_SERVER as $key => $value) {
			$log_message .= "<strong>$key</strong>: $value<br/>";
		}
		$log_message .= "</pre>
		<br />
		<hr /><br /><br />";
			
		if( is_file($error_file) === false ) {
			file_put_contents($error_file, '');
		}

		if( $clear ) {
			$content = '';
		} else {
			$content = file_get_contents($error_file);
		}

		file_put_contents($error_file, $log_message . $content);
	}
}