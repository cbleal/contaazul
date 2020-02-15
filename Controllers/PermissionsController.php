<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;

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
			// carrega o template
			$this->loadTemplate('permissions', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
}
