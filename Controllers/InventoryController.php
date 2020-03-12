<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Inventory;

class InventoryController extends Controller
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

		if ($u->hasPermission('inventory_view')) {
			$i = new Inventory();			
			$offset = 0;
			$data['inventory_list'] = $i->getList($offset, $u->getCompany());		
			$data['add_permission'] = $u->hasPermission('inventory_add');
			$data['edit_permission'] = $u->hasPermission('inventory_edit');
			$this->loadTemplate('inventory', $data);
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

		if ($u->hasPermission('inventory_add')) {

			$i = new Inventory();
			
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
			$this->loadTemplate('inventory_add', $data);
		} else {
			// volta para view clients
			header("Location: " . BASE_URL . "/inventory");
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

		if ($u->hasPermission('clients_edit')) {

			$c = new Clients();
			
			if (isset($_POST['name']) && !empty($_POST['name'])) {

				$name = addslashes($_POST['name']);
				$email = addslashes($_POST['email']);
				$phone = addslashes($_POST['phone']);
				$address_zipcode = addslashes($_POST['address_zipcode']);
				$address = addslashes($_POST['address']);
				$address_number = addslashes($_POST['address_number']);
				$address2 = addslashes($_POST['address2']);
				$address_neighb = addslashes($_POST['address_neighb']);
				$address_city = addslashes($_POST['address_city']);
				$address_state = addslashes($_POST['address_state']);
				$address_country = addslashes($_POST['address_country']);
				$stars = addslashes($_POST['stars']);
				$internal_obs = addslashes($_POST['internal_obs']);

				$c->edit($id, $name, $email, $phone, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $stars, $internal_obs, $u->getCompany());

				header("Location: " . BASE_URL . "/clients");
				
			}
			// carrega o cliente
			$data['client_info'] = $c->getInfo($id, $u->getCompany());
			// carrega o template
			$this->loadTemplate('clients_edit', $data);
		} else {
			// volta para view clients
			header("Location: " . BASE_URL . "/clients");
		}
	}
	public function delete($id)
	{
		echo "StandBy";
	}	
}
