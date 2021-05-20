<?php 

function form_input($fields)
{
	// Type
	if (array_key_exists('type', $fields))
	{
		if ($fields['type'] == 'text')
		{
			$type = 'text';
		}
		else if ($fields['type'] == 'email')
		{
			$type = 'email';
		}
		else if ($fields['type'] == 'password')
		{
			$type = 'password';
		}
		else if ($fields['type'] == 'file')
		{
			$type = 'file';
		}
		else
		{
			// echo 'Error en el type del input';
			die('<p style="color: red;">Error en el type del input</p>');
		}
	}
	else
	{
		$type = null;
	}

	// Id
	if (array_key_exists('id', $fields))
	{
		$id = $fields['id'];
	}
	else
	{
		$id = null;
	}

	// Name
	if (array_key_exists('name', $fields))
	{
		$name = $fields['name'];
	}
	else
	{
		$name = null;
	}

	// Class
	if (array_key_exists('class', $fields))
	{
		$class = $fields['class'];
	}
	else
	{
		$class = null;
	}

	// Placeholder	
	if (array_key_exists('placeholder', $fields))
	{
		$placeholder = $fields['placeholder'];
	}
	else
	{
		$placeholder = null;
	}

	// Value
	if (array_key_exists('value', $fields))
	{
		$value = $fields['value'];
	}
	else
	{
		$value = null;
	}

	// Verificacón si es de tipo file
	if ($type == 'file')
	{
		return '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" class="'.$class.'" >';
	}
	else
	{
		return '<input type="'.$type.'" id="'.$id.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" >';
	}
}

function input_submit($fields)
{
	// Name
	if (array_key_exists('name', $fields))
	{
		$name = $fields['name'];
	}
	else
	{
		$name = null;
	}

	// Class
	if (array_key_exists('class', $fields))
	{
		$class = $fields['class'];
	}
	else
	{
		$class = null;
	}

	// Id
	if (array_key_exists('id', $fields))
	{
		$id = $fields['id'];
	}
	else
	{
		$id = null;
	}

	// Value
	if (array_key_exists('value', $fields))
	{
		$value = $fields['value'];
	}
	else
	{
		$value = null;
	}

	return '<input type="submit" id="'.$id.'" name="'.$name.'" class="'.$class.'" value="'.$value.'" >';
}

function form_button($fields)
{
	// Name
	if (array_key_exists('name', $fields))
	{
		$name = $fields['name'];
	}
	else
	{
		$name = null;
	}

	// Class
	if (array_key_exists('class', $fields))
	{
		$class = $fields['class'];
	}
	else
	{
		$class = null;
	}

	// Id
	if (array_key_exists('id', $fields))
	{
		$id = $fields['id'];
	}
	else
	{
		$id = null;
	}

	//Value
	if (array_key_exists('value', $fields))
	{
		$value = $fields['value'];
	}
	else
	{
		$value = null;
	}

	return '<button type="button" class="'.$class.'" id="'.$id.'" name="'.$name.'">'.$value.'</button>';
}

// Form open
function form_open($action = "", $method = "", $options = [])
{
	// Id
	if (array_key_exists('id', $options))
	{
		$id = $options['id'];
	}
	else
	{
		$id = null;
	}

	// Class
	if (array_key_exists('class', $options))
	{
		$class = $options['class'];
	}
	else
	{
		$class = null;
	}

	$url = BASE_URL.'/'.$action;
	return '<form action="'.$url.'" method="'.$method.'" class="'.$class.'" id="'.$id.'" >';
}

// Form multipart
function form_multipart($action = "", $method = "", $options = [])
{
	// Id
	if (array_key_exists('id', $options))
	{
		$id = $options['id'];
	}
	else
	{
		$id = null;
	}

	// Class
	if (array_key_exists('class', $options))
	{
		$class = $options['class'];
	}
	else
	{
		$class = null;
	}

	$url = BASE_URL.'/'.$action;
	return '<form action="'.$url.'" method="'.$method.'"  class="'.$class.'" id="'.$id.'" enctype="multipart/form-data" >';
}

// Form close
function form_close()
{
	return '</form>';
}