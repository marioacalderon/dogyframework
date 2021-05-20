<?php 

function anchor($href, $value, $options = [])
{
	// Class
	if (array_key_exists('class', $options))
	{
		$class = $options['class'];
	}
	else
	{
		$class = null;
	}

	// Id	
	if (array_key_exists('id', $options))
	{
		$id = $options['id'];
	}
	else
	{
		$id = null;
	}

	$url = BASE_URL.'/'.$href;
	return '<a href="'.$url.'" class="'.$class.'" id="'.$id.'">'.$value.'</a>';
}