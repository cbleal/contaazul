<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Sales;

class SalesController extends Controller
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

		if ($u->hasPermission('sales_view')) {
			$s = new Sales();			
			$offset = 0;
			$data['sales_list'] = $s->getList($offset, $u->getCompany());		
			$data['add_permission'] = $u->hasPermission('sales_add');
			
			$this->loadTemplate('sales', $data);
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

		if ($u->hasPermission('sales_add')) {

			$s = new Sales();
			
			if (isset($_POST['name']) && !empty($_POST['name'])) {

				$name = addslashes($_POST['name']);
				$price = addslashes($_POST['price']);
				$quant = addslashes($_POST['quant']);
				$min_quant = addslashes($_POST['min_quant']);
				// formato moeda para gravar no banco de dados: 1234.56
				$price = str_replace(',', '.', str_replace('.', '', $price));

				$i->add($name, $price, $quant, $min_quant, 
						$u->getCompany(), $u->getId());

				header("Location: " . BASE_URL . "/inventory");
				
			}
			// carrega o template
			$this->loadTemplate('sales_add', $data);
		} else {
			// volta para view clients
			header("Location: " . BASE_URL . "/inventory");
		}
	}		
	public function delete($id)
	{
		$u = new Users();
		$u->setLoggedUser();
		if ($u->hasPermission('inventory_edit')) {
			$i = new Inventory();
			$i->delete($id, $u->getCompany(), $u->getId());
			header("Location: " . BASE_URL . "/inventory");
		}
	}	
}
