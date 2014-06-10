<?php
namespace Lean\File;

class Download extends \Singleton
{
	static public function force($path, $file, $name = null)
	{
		if (is_null($name)) $name = $file; 
		
		$path = $path . DIRECTORY_SEPARATOR . $file;
		header ("Content-Disposition: attachment; filename=".$name."");
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize($path));
		readfile($path);
	} 
}