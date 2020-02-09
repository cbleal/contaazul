<?php
namespace Controllers;

use \Core\Controller;

class LoginController extends Controller
{
	public function index()
	{
		$data = array();

		$this->loadView('login', $data);
	}
}