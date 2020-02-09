<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;

class HomeController extends Controller
{
	public function __construct()
	{
		//parent::__construct();		
		$u = new Users();
		if ($u->isLogged() == false) {
			header("Location: " . BASE_URL . "login");
		}
	}
	public function index()
	{
		$data = array();

		$this->loadTemplate('home', $data);
	}
}