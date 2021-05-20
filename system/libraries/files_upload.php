<?php 

trait files_upload
{

	public $file_errors = [];
	public $data;
	public $file_data;

	public function file($data)
	{
		$this->data = $data;
		$this->file_data = [
			'file_name' 	=> $_FILES[$this->data['file_name']]['name'],
			'file_tmp' 		=> $_FILES[$this->data['file_name']]['tmp_name'],
			'extensions' 	=> $this->data['allowed_extensions'],
			'upload_path' 	=> $this->data['upload_path'],
			'label'			=> $this->data['label'],
			'field_name' 	=> $this->data['file_name'],
			'file_ext'		=> pathinfo($_FILES[$this->data['file_name']]['name'], PATHINFO_EXTENSION)
		];

		// Validamos si el campo file está vacío
		if (empty($this->file_data['file_name']))
		{
			return $this->file_errors[$this->file_data['field_name']] = $this->file_data['label'].' es obligatorio'; 
		}

		// Validamos la extensión del archivo
		$file_extension = strtolower($this->file_data['file_ext']);
		$extensions = explode('|', $this->file_data['extensions']);

		if (!in_array($file_extension, $extensions))
		{
			return $this->file_errors[$this->file_data['field_name']] = 'Extensión '.$file_extension.' no es valida';
		}

		// Validamos el directorio que alojará los archivos subidos
		if (!file_exists($this->file_data['upload_path']))
		{
			$directory = rtrim($this->file_data['upload_path'], '/');
			return $this->file_errors[$this->file_data['field_name']] = $directory.' no es un directorio valido';
		}
	}

	// Corremos y validamos si existe un error
	public function file_run()
	{
		if (empty($this->file_errors))
		{
			// Cambiamos el nombre del archivo agregarndole al inio del él, el time()
			$file_name = pathinfo($this->file_data['file_name'], PATHINFO_FILENAME);
			$file_name = preg_replace('/\s+/', '_', $file_name);
			$file_name = time().$file_name;
			$file_name = $file_name.'.'.$this->file_data['file_ext'];
			
			// Movemos el archivo subido de temporal a la carpeta final
			move_uploaded_file($this->file_data['file_tmp'], $this->file_data['upload_path'].$file_name);


			return true;
		}
		else
		{
			$this->data = null;
			return false;
		}
	}
}