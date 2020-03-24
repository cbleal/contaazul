<?php
namespace Controllers;
use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Permissions;
use \Models\Purchases;
use \Models\Sales;
use \Models\Inventory;

class ReportsController extends Controller
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

		if ($u->hasPermission('reports_view')) {			
			// vai para a o template: reports
			$this->loadTemplate('reports', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function sales()
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

		if ($u->hasPermission('reports_view')) {

			// vai para a o template: reports_sales
			$this->loadTemplate('report_sales', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function sales_pdf()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		
		$data['statuses'] = array(
			'0' => 'Aguardando Pgto',
			'1' => 'Pago',
			'2' => 'Cancelado'
		);

		if ($u->hasPermission('reports_view')) {

			$client_name = addslashes($_GET['client_name']);
			$period1 	 = addslashes($_GET['period1']);
			$period2     = addslashes($_GET['period2']);
			$status      = addslashes($_GET['status']);
			$order       = addslashes($_GET['order']);

			$s = new Sales();
			$data['sales_list'] = $s->getSalesFiltered($client_name, $period1, $period2, $status, $order, $u->getCompany());
			$data['filters'] = $_GET;

			ob_start(); // todo o html não imprime na tela, envia p memória			
			$this->loadView('report_sales_pdf', $data);
			$html = ob_get_contents(); // pega da memória e armazena na variável
			ob_end_clean(); // limpa a memória

			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function purchases()
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

		if ($u->hasPermission('reports_view')) {
			// vai para o template report_purchases
			$this->loadTemplate('report_purchases', $data);
		}
		else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function purchases_pdf()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		
		$data['statuses'] = array(
			'0' => 'Aguardando Pgto',
			'1' => 'Pago',
			'2' => 'Cancelado'
		);

		if ($u->hasPermission('reports_view')) {

			// dados do formulario
			$provider_name = addslashes($_GET['provider_name']);
			$period1	   = addslashes($_GET['period1']);
			$period2	   = addslashes($_GET['period2']);
			$status 	   = addslashes($_GET['status']);
			$order	       = addslashes($_GET['order']);
			// cria o objeto
			$p = new Purchases();
			// array recebe uma lista
			$data['purchases_list'] = $p->getPurchasesFiltered($provider_name, $period1, $period2, $status, $order, $u->getCompany());
			// cria os filtros
			$data['filters'] = $_GET;
			// impressão
			// joga html para memória
			ob_start();
			// chama o view do html do relatório
			$this->loadView('report_purchases_pdf', $data);
			// atribui o html da memória a uma variavel
			$html = ob_get_contents();
			// limpa a memória
			ob_end_clean();
			// cria objeto da classe mpdf
			$mpdf = new \Mpdf\Mpdf();
			// carrega o html
			$mpdf->WriteHTML($html);
			// manda para saída
			$mpdf->Output();
		}
		else {

			header("Location: " . BASE_URL);
		}
	}
	public function inventory()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();
		$company = new Companies($u->getCompany());
		$data['company_name'] = $company->getName();
		$data['user_email'] = $u->getEmail();
		
		if ($u->hasPermission('reports_view')) {

			// vai para a o template: reports_sales
			$this->loadTemplate('report_inventory', $data);
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	public function inventory_pdf()
	{
		$data = array();

		$u = new Users();
		$u->setLoggedUser();	

		if ($u->hasPermission('reports_view')) {

			$i = new Inventory();
			$data['inventory_list'] = $i->getInventoryFiltered($u->getCompany());
			
			ob_start(); // todo o html não imprime na tela, envia p memória			
			$this->loadView('report_inventory_pdf', $data);
			$html = ob_get_contents(); // pega da memória e armazena na variável
			ob_end_clean(); // limpa a memória

			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		} else {
			// volta para home
			header("Location: " . BASE_URL);
		}
	}
	
}
