<?php
namespace Lean\Utils;

class Select
{
	public static function create()
	{
		
	} 
	
	public static function create_options($list, array $options = null) // $firstblank = true, $contentdefault = null, $option_selected = null)
	{
		$option_selected = null;
		$option_first_ = null;
		
		
		if(is_null($options))
		{
			if(isset($options['option_selected'])) $option_selected = $options['option_selected'];
			if(isset($options['option_selected'])) $option_selected = $options['option_selected'];
		}
		
		
		$output = null;
		
		$value = (string) $value;
		
		if ($firstblank == true)
		{
			if (is_null($contentdefault) || $options) $contentdefault = '&nbsp';
				
			$output = "<option value=''>$contentdefault</option>";
		}

		if ($options)
		{
			foreach ($options as $key => $option)
			{
				if ($value === (string) $key)
				$output .= "<option value='$key' selected>$option</option>";
				else
				$output .= "<option value='$key'>$option</option>";
			}
		}

		return $output;
	}
}