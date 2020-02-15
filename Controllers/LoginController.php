<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;

class LoginController extends Controller
{
	public function index()
	{
		$data = array();

		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$email = addslashes($_POST['email']);
			$password = addslashes($_POST['password']);
			$u = new Users();
			if ($u->doLogin($email, $password)) {
				header("Location: " . BASE_URL);
			} else {
				$data['error'] = "E-mail e/ou senha inválidos.";
			}
		}

		$this->loadView('login', $data);
	}

	public function logout()
	{
		$u = new Users();
		// definir o usuário
		$u->setLoggedUser();
		if ($u->hasPermission('logout')) {
			// sai
			$u->logout();
			header("Location: " . BASE_URL);
		} else {
			echo "NÃO PODE FAZER LOGOUT...";
			exit;
		}
		
	}
}