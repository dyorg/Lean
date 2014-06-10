<?php

class Myapp_Element_Label
{
	static public function message($string)
	{
		if (!empty($string)) return $out = "<span class='message'>$string</span>";
	}

	static public function error($string)
	{
		if (!empty($string)) return $out = "<span class='error'>$string</span>";
	}
}