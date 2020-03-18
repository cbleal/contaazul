<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Clients;

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

}