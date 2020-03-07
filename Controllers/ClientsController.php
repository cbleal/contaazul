<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Clients;

class ClientsController extends Controller
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
			$c = new Clients();
			// offset
			$offset = 0;
			// número de clientes por página
			$clients_p = 10;
			// página atual
			$data['p'] = 1;
			// pegar a página clicada
			if (isset($_GET['p']) && !empty($_GET['p'])) {
				$data['p'] = intval($_GET['p']);
				if ($data['p'] == 0) {
					$data['p'] = 1;
				}
			}
			// calcular offset
			$offset = ($clients_p * ($data['p'] - 1));
			// número de registro de clientes
			$data['clients_count'] = $c->getCount($u->getCompany());			
			// calcular o número de páginas
			$data['p_count'] = ceil($data['clients_count']/$clients_p);
			// lista de clientes
			$data['clients_list'] = $c->getList($offset, $u->getCompany());
			// permissão do usuário
			$data['edit_permission'] = $u->hasPermission('clients_edit');
			// carrega o template
			$this->loadTemplate('clients', $data);
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

				$c->add($name, $email, $phone, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $stars, $internal_obs, $u->getCompany());

				header("Location: " . BASE_URL . "/clients");
				
			}
			// carrega o template
			$this->loadTemplate('clients_add', $data);
		} else {
			// volta para view clients
			header("Location: " . BASE_URL . "/clients");
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
