<?php 

trait session
{
	public function start()
	{
		// Inicio de sesión
		session_start();
	}

	// Creación de sessión
	public function set_session($name, $value = '')
	{
		// Ajustamos los dtos de la sesión
		if (!empty($name))
		{
			if (is_array($name) && empty($value))
			{
				foreach ($name as $key => $session_name):
					$_SESSION[$key] = $session_name;
				endforeach;
			}
			else if (!is_array($name) && !empty($value))
			{
				$_SESSION[$name] = $value;
			}
		}
	}

	// Obtener la sesión actual
	public function get_session($name)
	{
		// Obetenemos los datos de la sesión actual
		if (!empty($name))
		{
			return $_SESSION[$name];
		}
	}

	// Creación de flashdata
	public function set_flashdata($name, $message)
	{
		// Ajustamos los valores del flash message
		if (!empty($name) && !empty($message))
		{
			$_SESSION[$name] = $message;
		}
	}

	// Mostramos el flashdata
	public function flashdata($name, $class = '')
	{
		// Ajustamos el flashdata
		if (!empty($name) && isset($_SESSION[$name]))
		{
			echo $_SESSION[$name];
			unset($_SESSION[$name]);
		}
	}

	// vaciar datos de la sesión actual
	public function unset_session($name)
	{
		if (!empty($name))
		{
			if (is_array($name))
			{
				foreach ($name as $key):
					unset($_SESSION[$key]);
				endforeach;
			}
			else
			{
				unset($_SESSION[$name]);
			}
		}
	}

	// Eliminar la sesión actual
	public function destroy_session()
	{
		session_destroy();
	}
}