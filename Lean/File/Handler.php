<?php

class Myapp_File_Handler
{
	static public function listFiles($dir)
	{
		if (!is_dir($dir)) throw new Exception('Diretório não existe');
		
		$open = opendir($dir);

		if ($open)
		{
			$files = array();

			while($file = readdir($open))
			{
				if ($file !== '.' && $file !== '..')
				{
					$files[] = $file;
				}
			}			
			unset($file);
		}

		closedir($open);

		return $files;
	}

	static public function sizeHuman($size)
	{
		$bytes = array('KB', 'KB', 'MB', 'GB', 'TB');

		if($size <= 999){
			$size = 1;
		}
		for($i = 0; $size > 999; $i++) {
			$size /= 1024;
		}

		$sizehuman = round($size).$bytes[$i];

		return $sizehuman;
	}
}