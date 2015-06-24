<?php

class Myapp_File_Remove
{
	private $file;
	
	private $path;
	
	public $error;
	
	public $message;
	
	public function __construct($file, $path)
	{
		$this->file = $file;
		$this->path = $path;
	}
	
	public function execute()
	{
		if (!is_dir($this->path))
		{
			$this->error = "Não existe o diretório $this->path";
			return false;
		}
		elseif (!file_exists($this->path . DIRECTORY_SEPARATOR . $this->file))
		{
			$this->error = "Não existe o arquivo " . $this->path . DIRECTORY_SEPARATOR . $this->file;
			return false;
		}
		else
		{
			unlink($this->path . DIRECTORY_SEPARATOR . $this->file);
			$this->message = "Arquivo removido com sucesso";
			return true;
		}
	}
}