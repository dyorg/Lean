<?php

class Myapp_File_Upload
{
	private $file;

	private $destiny;
	
	private $newName = false;

	public $fileName;
	
	public $fileNameOriginal;

	public $fileType;

	public $fileSize;

	public $fileTemp;

	public $error = null;
	
	public $success = null;
	
	public $uploaded = null;
	
	public function __construct($file, $destiny)
	{
		$this->file = $file;
		$this->destiny = $destiny;
	}
	
	public function generateNewName()
	{
		$this->newName = true;
		return $this;
	}
	
	public function process()
	{
		if(!$this->file){
			$this->error = 'Nenhum arquivo enviado!';
			return false;
		}
		else
		{
			$this->fileName = $this->fileNameOriginal = $this->file['name'];
			if ($this->newName) $this->fileName = uniqid() . substr(strrchr($this->fileName, '.'), 0);
			$this->fileType = $this->file['type'];
			$this->fileSize = $this->file['size'];
			$this->fileTemp = $this->file['tmp_name'];
			$error = $this->file['error'];
		}

		switch ($error){
			case 0:
				break;
			case 1:
				$this->error = 'O tamanho do arquivo é maior que o definido nas configurações do servidor';
				return false;
			case 2:
				$this->error = 'O tamanho do arquivo é maior do que o permitido';
				return false;
			case 3:
				$this->error = 'O upload não foi concluído';
				return false;
			case 4:
				$this->error = 'O upload não foi feito';
				return false;
		}

		if($error == 0)
		{
			if(!is_uploaded_file($this->fileTemp))
			{
				$this->error = 'Erro ao processar arquivo';
				return false;
			}
			else
			{
				if (!is_dir($this->destiny)) mkdir($this->destiny);
				
				if(!move_uploaded_file($this->fileTemp, $this->destiny. DIRECTORY_SEPARATOR . $this->fileName))
				{
					$this->error = 'Não foi possível salvar o arquivo';
					return false;
				}
				else
				{
					$this->success = 'Upload concluído com sucesso';
					$this->uploaded = true;
				}
			}
		}
		
		return true;
	}
}