<?php 

class Controller {

	use form_validation, files_upload, session;

	public function __construct()
	{
		// Inicio de sesion
		$this->start();

		// Cargamos automaticamente las funciones de ayuda del systema
		if (file_exists('../application/config/autoloads.php'))
		{
			require_once '../application/config/autoloads.php';
			$functions = $autoloads['functions'];
			$this->functions($functions);
		}
	}

	// Cargamos la vista al controlador
	public function view($view_name, $data = [])
	{
		if (file_exists('../application/views/'.$view_name.'.php'))
		{
			require_once '../application/views/'.$view_name.'.php';
		}
		else
		{
			die('Vista no encontrada.');
		}
	}

	// Cargamos el modelo al controlador
	public function model($model_name)
	{
		if (file_exists('../application/models/'.$model_name.'.php'))
		{
			require_once '../application/models/'.$model_name.'.php';
			$update_model_name = ucwords($model_name);
			return new $update_model_name;
		}
		else
		{
			die('Modelo no encontrado.');
		}
	}

	// Método para cargar helpers
	public function helper($helper_name)
	{
		if (file_exists('../application/helpers/'.$helper_name.'.php'))
		{
			require_once '../application/helpers/'.$helper_name.'.php';
		}
		else
		{
			die('Error en cargar el helper, revise el nombre.');
		}
	}

	// Método para cargar funciones que ayudan
	public function functions($function_name)
	{
		if (!empty($function_name))
		{
			foreach ($function_name as $function) 
			{
				if (file_exists('../system/libraries/functions/'.$function.'.php'))
				{
					require_once 'functions/'.$function.'.php';
				}
			}
		}
	}

	// Método POST
	public function post($field_name)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'post' || $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			return strip_tags(trim($_POST[$field_name]));
		}
		else
		{
			die('Error, método no permitido.');
		}
	}

	// Método GET
	public function get($field_name)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'get' || $_SERVER['REQUEST_METHOD'] == 'GET')
		{
			return strip_tags(trim($_GET[$field_name]));
		}
		else
		{
			die('Error, método no permitido.');
		}
	}

	// Método URI
	public function uri($segment)
	{
		if (isset($_GET['url']))
		{
			$url = $_GET['url'];

			// Eliminamos espacios en blanco al final de la url
			$url = rtrim($url);

			// Filtramos y eliminamos los caracteres prohibidos de la url
			$url = filter_var($url, FILTER_SANITIZE_URL);

			// Dividimos la url teneido encuenta la barra inclinada
			$url = explode('/', $url);

			return $url[$segment];
		}
	}
}