<?php 

function link_css($css_path)
{
	if (!empty($css_path))
	{
		return '<link rel="stylesheet" href="'.BASE_URL.'/'.$css_path.'">';
	}
}