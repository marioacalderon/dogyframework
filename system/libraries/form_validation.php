<?php 

trait form_validation 
{
	public $errors = [];

	public function validation($field_name, $label, $rules)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'post' || $_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$data = trim($_POST[$field_name]);
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'get' || $_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$data = trim($_GET[$field_name]);
		}

		$rules = explode('|', $rules);

		$pattern = '/^[a-zA-Z ]+$/';
		$int_pattern = '/^[0-9]+$/';

		// Regla de verificacion si esta vacío
		if (in_array('required', $rules))
		{
			if (empty($data))
			{
				return $this->errors[$field_name] = $label.' es obligatotio';
			}
		}

		// Regla de verificacion si es solo texto
		if (in_array('not_int', $rules))
		{
			if (!preg_match($pattern, $data))
			{
				return $this->errors[$field_name] = $label.' debe contener solo caracteres alfabéticos';
			}
		}

		// Regla de verificacion sie es solo números
		if (in_array('int', $rules))
		{
			if (!preg_match($int_pattern, $data))
			{
				return $this->errors[$field_name] = $label.' debe contener solo caracteres numéricos';
			}
		}

		// Regla de verificacion si cumple con la longitud mínima
		if (in_array('min_length', $rules))
		{
			$min_length_index = array_search('min_length', $rules);

			$min_length_value = $min_length_index + 1;
			$min_length_value = $rules[$min_length_value];

			if (strlen($data) < $min_length_value)
			{
				return $this->errors[$field_name] = $label.' debe tener una logintud mínima de '.$min_length_value.' caracteres';
			}
		}

		// Regla de verificacion si cumple con la longitud máxima
		if (in_array('max_length', $rules))
		{
			$max_length_index = array_search('max_length', $rules);
			$max_length_value = $max_length_index + 1;
			$max_length_value = $rules[$max_length_value];

			if (strlen($data) > $max_length_value)
			{
				return $this->errors[$field_name] = $label.' debe tener una logintud máxima de '.$max_length_value.' caracteres';
			}
		}

		// Regla para confirmar contraseña
		if (in_array('confirm', $rules))
		{
			$confirm_rule_index = array_search('confirm', $rules);
			$confirm_rule_index = $confirm_rule_index + 1;
			$confirm_rule_password = $rules[$confirm_rule_index];

			if ($_SERVER['REQUEST_METHOD'] == 'post' || $_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$password = trim($_POST[$confirm_rule_password]);
			}
			else if ($_SERVER['REQUEST_METHOD'] == 'get' || $_SERVER['REQUEST_METHOD'] == 'GET')
			{
				$password = trim($_GET[$confirm_rule_password]);
			}

			if ($data !== $password)
			{
				return $this->errors[$field_name] = $label.' no coincide';
			}
		}

		// Regla para validar valor único
		if (in_array('unique', $rules))
		{
			$unique_index = array_search('unique', $rules);
			$table_index = $unique_index + 1;
			$table_name = $rules[$table_index];

			require_once '../system/libraries/Model.php';

			$db = new Model;
			if ($db->select($table_name, [$field_name => $data]))
			{
				if ($db->count() > 0)
				{
					return $this->errors[$field_name] = $label.' debe ser un valor único';
				}
			}
		}
	}

	// Corremos la validación
	public function run()
	{
		if (empty($this->errors))
		{
			return true;
		}
		{
			return false;
		}
	}

	// Ajustamos los valores de los campos validados con set_value()
	public function set_value($field_name)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'post')
		{
			return $_POST[$field_name];
		}
		else if ($_SERVER['REQUEST_METHOD'] == 'GET' ||$_SERVER['REQUEST_METHOD'] == 'get')
		{
			return $_GET[$field_name];
		}
	}

	// password hash
	public function hash($password)
	{
		if (!empty($password))
		{
			return password_hash($password, PASSWORD_DEFAULT);
		}
	}
}