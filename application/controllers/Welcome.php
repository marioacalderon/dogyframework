<?php 

class Welcome extends Controller {

	public function __construct()
	{
		parent::__construct();
	}

	// Método inicial del controlador
	public function index()
	{
		$data = 'Bienvenido al controlador';

		$this->view('welcome', $data);
	}
	
}