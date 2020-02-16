<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;

class PermissionsController extends Controller
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

		if ($u->hasPermission('permissions_view')) {
			$permissions = new Permissions();
			$data['permissions_list'] = $permissions->getList($u->getCompany());
			// carrega o template
			$this->loadTemplate('permissions', $data);
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

		if ($u->hasPermission('permissions_view')) {

			$permissions = new Permissions();

			if (isset($_POST['name']) && !empty($_POST['name'])) {

				$pname = addslashes($_POST['name']);
				$permissions->add($pname, $u->getCompany());

				header("Location: " . BASE_URL . "/permissions");
			}	
			// carrega o template
			$this->loadTemplate('permissions_add', $data);
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

			$permissions = new Permissions();
			//deleta
			$permissions->delete($id);
			header("Location: " . BASE_URL . "/permissions");			
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
}
