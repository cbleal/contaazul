<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Purchases;
use \Models\Inventory;

class PurchasesController extends Controller
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

		if ($u->hasPermission('purchases_view')) {
			$p = new Purchases();			
			$offset = 0;
			$data['purchases_list'] = $p->getList($offset, $u->getCompany());		
			$data['add_permission'] = $u->hasPermission('purchases_view');
			
			$this->loadTemplate('purchases', $data);
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

		if ($u->hasPermission('purchases_add')) {
			
			if (isset($_POST['provider_id']) && !empty($_POST['provider_id'])) {

				$p = new Purchases();

				$id_provider = addslashes($_POST['provider_id']);				
				$status      = addslashes($_POST['status']);
				$quant       = $_POST['quant'];				
				
				// função adiciona do objeto
				$p->addPurchase($u->getCompany(), $id_provider, $u->getId(), $quant, $status);
				// redireciona para página
				header("Location: " . BASE_URL . "/purchases");
				
			}
			// carrega o template
			$this->loadTemplate('purchases_add', $data);
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
			
				$p = new Purchases();
				$data['permission_edit'] = $u->hasPermission('purchases_edit');

			if (isset($_POST['status']) && $data['permission_edit']) {
							
				$status = addslashes($_POST['status']);			
				
				$p->changeStatus($status, $id, $u->getCompany());
				
				header("Location: " . BASE_URL . "/purchases");
				
			}

			$data['purchases_info'] = $p->getInfo($id, $u->getCompany());			
			
			$this->loadTemplate('purchases_edit', $data);
		} else {
			
			header("Location: " . BASE_URL);
		}
	}		
	
}
