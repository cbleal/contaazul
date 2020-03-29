<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Clients;
use \Models\Providers;
use \Models\Inventory;
use \Models\Cidades;

class AjaxController extends Controller
{
	public function __construct()
	{
		$u = new Users();
		if ($u->isLogged() == false) {
			header("Location: " . BASE_URL . "login");
		}
	}

	public function index() {}

	public function search_clients()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();
		
		$c = new Clients();

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = addslashes($_GET['q']);
			$clients = $c->searchClientByName($q, $u->getCompany());
			foreach ($clients as $citem) {
				$data[] = array(
					'id' => $citem['id'],
					'name' => $citem['name'],
					'link' => BASE_URL . 'clients/edit/' . $citem['id']
				);
			}
		}

		echo json_encode($data);
	}
	public function add_client()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();
		
		$c = new Clients();

		if (isset($_POST['name']) && !empty($_POST['name'])) {
			$name = addslashes($_POST['name']);
			$data['id'] = $c->add($u->getCompany(), $name);
		}

		echo json_encode($data);
	}
	public function search_providers()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();
		
		$p = new Providers();

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = addslashes($_GET['q']);
			$providers = $p->searchProviderByName($q, $u->getCompany());
			foreach ($providers as $citem) {
				$data[] = array(
					'id' => $citem['id'],
					'name' => $citem['name'],
					'link' => BASE_URL . 'providers/edit/' . $citem['id']
				);
			}
		}

		echo json_encode($data);
	}
	public function add_provider()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();
		
		$p = new Providers();

		if (isset($_POST['name']) && !empty($_POST['name'])) {
			$name = addslashes($_POST['name']);
			$data['id'] = $p->add($u->getCompany(), $name);
		}

		echo json_encode($data);
	}
	public function search_products()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();		

		$i = new Inventory();

		if (isset($_GET['q']) && !empty($_GET['q'])) {
			$q = addslashes($_GET['q']);
			$data = $i->searchProductByName($q, $u->getCompany());			
		}

		echo json_encode($data);
	}
	public function getListCities()
	{
		$data = array();
		$u = new Users();
		$u->setLoggedUser();
		
		$ci = new Cidades();

		if (isset($_GET['state']) && !empty($_GET['state'])) {
			$state = addslashes($_GET['state']);
			$data = $ci->getListCities($state);

		}

		// foreach ($$data['cities'] as $citem) {
		// 	$data[] = array(
		// 		'codigo_municipio' => $citem['CodigoMunicipio'],
		// 		'nome' => $citem['Nome'],					
		// 	);
		// }

		echo json_encode($data);
	}

}