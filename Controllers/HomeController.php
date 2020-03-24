<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Companies;
use \Models\Sales;

class HomeController extends Controller
{
	public function __construct()
	{
		//parent::__construct();		
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

		$s = new Sales();

		$data['products_sold'] = $s->getSoldProducts(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

		$data['revenue'] = $s->getTotalRevenue(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

		$data['expenses'] = $s->getTotalExpense(date('Y-m-d', strtotime('-30 days')), date('Y-m-d'), $u->getCompany());

		$data['days_list'] = array();
		for ($i=30; $i>0; $i--) {
			$data['days_list'][] = date('d/m', strtotime('-'.$i.' days'));
		}

		$this->loadTemplate('home', $data);
	}
}