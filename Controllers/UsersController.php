<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;

class UsersController extends Controller
{
	public function __construct()
	{
		// parent::__construct();		
		$u = new Users();
		if ($u->isLogged() == false) {
			header("Location: " . BASE_URL . "login");
		}
	}
	public function index()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();

		if ($u->hasPermission('users_view')) {
			$permissions = new Permissions();
			$data['users_list'] = $u->getList($u->getCompany());
			// carrega o template
			$this->loadTemplate('users', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function add()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();

		if ($u->hasPermission('users_view')) {

			$permissions = new Permissions();
			$data['users_group_list'] = $permissions->getGroupList($u->getCompany());

			if (isset($_POST['email']) && !empty($_POST['email'])) {

				$email    = addslashes($_POST['email']);
				$password = addslashes($_POST['password']);
				$id_group = addslashes($_POST['group']);

				$res = $u->add($email, $password, $id_group, $u->getCompany());

				if ($res == '1') {
					header("Location: " . BASE_URL . "/users");					
				} else {
					$data['error_msg'] = 'Usuário já cadastrado.';
				}
			}	
			// carrega o template
			$this->loadTemplate('users_add', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}	
	public function edit($id)
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();
		
		if ($u->hasPermission('permissions_view')) {

			$permissions = new Permissions();
			$data['users_group_list'] = $permissions->getGroupList($u->getCompany());
			$data['user_info'] = $u->getInfo($id, $u->getCompany());

			if (isset($_POST['group']) && !empty($_POST['group'])) {				
				$password = addslashes($_POST['password']);
				$id_group = addslashes($_POST['group']);
				$u->edit($password, $id_group, $id, $u->getCompany());

				header("Location: " . BASE_URL . "/users");
			}	
			// carrega o template
			$this->loadTemplate('users_edit', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function delete($id)
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();

		if ($u->hasPermission('permissions_view')) {

			//deleta
			$u->delete($id, $u->getCompany());
			header("Location: " . BASE_URL . "/users");			
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}	
}
