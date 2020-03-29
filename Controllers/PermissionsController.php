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
			// objeto
			$permissions = new Permissions();
			// offset
			$offset = 0;
			// número de permissões por página = 10
			$num_reg_pages = 10;
			// página atual = 1
			$data['page'] = 1;
			// pegar a página clicada
			if (isset($_GET['p']) && !empty($_GET['p'])) {
				$data['page'] = intval($_GET['page']);				
				if ($data['page'] == 0) {
					$data['page'] = 1;
				}
			}
			// calcular o offset = numero registros por pagina * (pagina clicada - 1)
			$offset = ( $num_reg_pages * ($data['page'] - 1) );
			// número de registros de permissões
			$data['num_registers'] = $permissions->getCount($u->getCompany());
			// calcular o número de páginas = núm registros / núm. de registros p pagina
			$data['num_pages'] = ceil($data['num_registers'] / $num_reg_pages);

			$data['permissions_list'] = $permissions->getList($offset, $u->getCompany());	
			$data['permissions_group_list'] = $permissions->getGroupList($u->getCompany());
			$data['activetab'] = false;

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
	public function add_group()
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

			if (isset($_POST['name']) && !empty($_POST['name'])) {

				$pname = addslashes($_POST['name']);				
				$plist = $_POST['permissions'];
				$permissions->addGroup($pname, $plist, $u->getCompany());

				header("Location: " . BASE_URL . "/permissions");
			}	
			// carrega o template
			$this->loadTemplate('permissions_add_group', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function edit_group($id)
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
			$data['group_info'] = $permissions->getGroup($id);

			if (isset($_POST['name']) && !empty($_POST['name'])) {				
				$pname = addslashes($_POST['name']);
				$plist = $_POST['permissions'];				
				$permissions->editGroup($pname, $plist, $id, $u->getCompany());

				header("Location: " . BASE_URL . "/permissions");
			}	
			// carrega o template
			$this->loadTemplate('permissions_edit_group', $data);
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
	public function delete_group($id)
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
			$permissions->deleteGroup($id);
			header("Location: " . BASE_URL . "/permissions");			
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}	
}
