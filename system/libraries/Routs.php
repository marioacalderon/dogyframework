<?php

class Routs {

	/*

	 * @Framework Name 	: Dogy Framework
	 * @Author Name 		: Mario Álvarez
	 * @License 			: MIT
	 * @Version 			: 1.0.0
	 * @Descripction 	: Clase Rutas, se obtiene la url, se divide y se sanitiza

	*/

	private $controller = DEFAULT_CONTROLLER;
	private $method 	= 'index';
	private $param		= [];

	public function __construct()
	{
		$url = $this->url();
		if (!empty($url))
		{
			if (file_exists('../application/controllers/'.$url[0].'.php'))
			{
				$this->controller = ucwords($url[0]);
				// Removemos de la url el indice del controlador
				unset($url[0]);
			}
			else
			{
				require '../application/controllers/ErrorController.php';
				$controller = new ErrorController();
				$controller->notfound();
				exit();
			}
		}

		// Incluir controlador
		require_once '../application/controllers/'.$this->controller.'.php';

		// Instanciar clase controlador
		$this->controller = new $this->controller;

		// Evaluamos si el método existe
		if (isset($url[1]) && !empty($url[1]))
		{
			if (method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				// Removemos de la url el indice del método
				unset($url[1]);
			}
			else
			{
				die('Método no encontrado.');
			}
		}

		// Evaluamos si existen parametros
		if (isset($url))
		{
			$this->param = $url;
		}
		else
		{
			$this->param = [];
		}

		call_user_func_array([$this->controller, $this->method], $this->param);
	}

	public function url()
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

			return $url;

		}
	}
}

