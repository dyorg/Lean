<?php

class Myapp_Export_Header
{
	static private function export($filename)
	{
		ob_clean();
		
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-Disposition: attachment; filename={$filename}" );
		header ("Content-Description: PHP Generated Data" );
	}

	/* Exportar para arquivos RTF/DOC */
	static public function toWord($filename)
	{
		self::export($filename);
		header( "Content-type: application/msword" );
	}

	/* Exportar para arquivos RTF/DOC */
	static public function toPDF($filename)
	{
		self::export($filename);
		header( "Content-type: application/pdf" );
	}

	static public function toXLS($filename)
	{
		self::export($filename);
		header("Content-type: application/x-msdownload");
		//header ("Content-type: application/x-msexcel");
	}
}