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
		$data['statuses'] = array(
			'0' => 'Aguardando Pgto',
			'1' => 'Pago',
			'2' => 'Cancelado'
		);

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
			
			if (isset($_POST['client_id']) && !empty($_POST['client_id'])) {

				$s = new Sales();

				$id_client   = addslashes($_POST['client_id']);
				$total_price = addslashes($_POST['total_price']);
				$status      = addslashes($_POST['status']);
				
				// formato moeda para gravar no banco de dados: 1234.56
				$total_price = str_replace(',', '.', str_replace('.', '', $total_price));

				$s->add($u->getCompany(), $id_client, $u->getId(), $total_price, $status);

				header("Location: " . BASE_URL . "/sales");
				
			}
			// carrega o template
			$this->loadTemplate('sales_add', $data);
		} else {
			// volta para view sales
			header("Location: " . BASE_URL);
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
