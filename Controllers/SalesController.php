<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Sales;
use \Models\Inventory;

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
		$data['statuses'] = array(
			'0' => 'Aguardando Pgto',
			'1' => 'Pago',
			'2' => 'Cancelado'
		);

		if ($u->hasPermission('sales_view')) {

			$s = new Sales();			

			$offset = 0;			
			$num_reg_pag = 10;
			$data['pagina_atual'] = 1;

			if (isset($_GET['p']) && !empty($_GET['p'])) {
				$data['pagina_atual'] = intval($_GET['p']);
				if ($data['pagina_atual'] == 0) {
					$data['pagina_atual'] = 1;
				}
			}

			$offset = ( $num_reg_pag * ($data['pagina_atual'] - 1) );

			$data['num_registros'] = $s->getCount($u->getCompany());
			$data['num_paginas']   = ceil($data['num_registros']/$num_reg_pag);

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
			
			if (isset($_POST['client_id']) && !empty($_POST['client_id'])) {

				$s = new Sales();

				$id_client   = addslashes($_POST['client_id']);
				// $total_price = addslashes($_POST['total_price']);
				$status      = addslashes($_POST['status']);
				$quant       = $_POST['quant'];				
				
				// função adiciona do objeto
				$s->addSale($u->getCompany(), $id_client, $u->getId(), $quant, $status);
				// redireciona para página
				header("Location: " . BASE_URL . "/sales");
				
			}
			// carrega o template
			$this->loadTemplate('sales_add', $data);
		} else {
			// volta para view sales
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
		$data['statuses'] = array(
			'0' => 'Aguardando Pgto',
			'1' => 'Pago',
			'2' => 'Cancelado'
		);

		if ($u->hasPermission('sales_view')) {
			
				$s = new Sales();
				$data['permission_edit'] = $u->hasPermission('sales_edit');

			if (isset($_POST['status']) && $data['permission_edit']) {
							
				$status = addslashes($_POST['status']);			
				
				$s->changeStatus($status, $id, $u->getCompany());
				
				header("Location: " . BASE_URL . "/sales");
				
			}

			$data['sales_info'] = $s->getInfo($id, $u->getCompany());			
			
			$this->loadTemplate('sales_edit', $data);
		} else {
			
			header("Location: " . BASE_URL);
		}
	}		
	
}
