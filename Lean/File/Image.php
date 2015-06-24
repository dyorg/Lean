<?php

class Myapp_File_Image
{
	public function exibir($image, $type)
	{
		header('Content-type'. $type);
		echo $image;
	}
}