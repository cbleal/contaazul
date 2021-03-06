<?php
namespace Models;
use \Core\Model;
use \Models\Inventory;

class Sales extends Model
{	
	public function getList($offset, $id_company)
	{
		$array = array();
		$sql = "SELECT
					s.id,
					c.name,
					s.date_sale,
					s.total_price,
					s.status
				FROM sales AS s
				LEFT JOIN clients AS c
				ON c.id = s.id_client
				WHERE s.id_company = :id_company
				ORDER BY s.date_sale DESC
				LIMIT $offset,10";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}
		
		return $array;
	}
	public function getInfo($id, $id_company)
	{
		$array = array();

		// INFORMAÇÕES DA VENDA E NOME DO CLIENTE
		$sql = "SELECT *,
				( SELECT clients.name FROM clients WHERE clients.id = sales.id_client ) AS client_name 
				FROM sales 
				WHERE 
				id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$array['info'] = $stmt->fetch();
		}

		// INFORMAÇÕES DOS PRODUTOS DA VENDA E NOME DO PRODUTO
		$sql = "SELECT 
				sales_products.quant,
				sales_products.sale_price,
				inventory.name 
				FROM sales_products 
				LEFT JOIN inventory ON inventory.id = sales_products.id_product 
				WHERE sales_products.id_sale = :id_sale 
				AND sales_products.id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_sale", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$array['products'] = $stmt->fetchAll();
		}

		return $array;
	}
	public function getCount($id_company)
	{
		$r = 0;

		$sql = "SELECT
				COUNT(*) AS c
				FROM sales
				WHERE id_company = :id_company";				

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$row = $stmt->fetch();
		$r = $row['c'];

		return $r;
	}
	public function setLog($id_company, $id_product, $id_user, $action)
	{
		$sql = "INSERT INTO inventory_history SET id_company = :id_company, id_product = :id_product, id_user = :id_user, action = :action, date_action = NOW()";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id_product", $id_product);
		$stmt->bindValue(":id_user", $id_user);
		$stmt->bindValue(":action", $action);
		$stmt->execute();
	}
	public function addSale($id_company, $id_client, $id_user, $quant, $status)
	{
		$i = new Inventory();

		// ADICIONAR A VENDA
		$sql = "INSERT INTO sales SET id_company = :id_company, id_client = :id_client, id_user = :id_user, date_sale = NOW(), total_price = :total_price, status = :status";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id_client", $id_client);
		$stmt->bindValue(":id_user", $id_user);
		$stmt->bindValue(":total_price", 0); // ADD TOTAL_PRICE = 0
		$stmt->bindValue(":status", $status);
		$stmt->execute();

		// ID DA VENDA
		$id_sale = $this->db->lastInsertId();

		// CALCULAR O TOTAL_PRICE
		$total_price = 0;
		foreach ($quant as $id_prod => $quant_prod) {
			// ATRAVÉS DO ID DO PRODUTO PEGAR O VALOR DO MESMO
			$sql = "SELECT price FROM inventory WHERE id = :id AND id_company = :id_company";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":id", $id_prod);
			$stmt->bindValue(":id_company", $id_company);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				// pegar o valor
				$row = $stmt->fetch();
				$price = $row['price'];

				// ADICIONA OS PRODUTOS DA VENDA (SALES_PRODUCTS)
				$sqlp = "INSERT INTO sales_products SET id_company = :id_company, id_sale = :id_sale, id_product = :id_product, quant = :quant, sale_price = :sale_price";
				$stmtp = $this->db->prepare($sqlp);
				$stmtp->bindValue(":id_company", $id_company);
				$stmtp->bindValue(":id_sale", $id_sale);
				$stmtp->bindValue(":id_product", $id_prod);
				$stmtp->bindValue(":quant", $quant_prod);
				$stmtp->bindValue(":sale_price", $price);
				$stmtp->execute();

				// DAR BAIXA NO ESTOQUE (INVENTORY)
				$i->decrease($id_prod, $id_company, $quant_prod, $id_user);

				$total_price += $price * $quant_prod;
			}
		}

		// ATUALIZAR O CAMPO TOTAL_PRICE NA TABELA SALES
		$sql = "UPDATE sales SET total_price = :total_price WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":total_price", $total_price);
		$stmt->bindValue(":id", $id_sale);
		$stmt->execute();
			
	}
	public function edit($id, $name, $price, $quant, $min_quant, $id_company, $id_user)
	{
		$sql = "UPDATE inventory SET name = :name, price = :price, quant = :quant, min_quant = :min_quant WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":price", $price);
		$stmt->bindValue(":quant", $quant);
		$stmt->bindValue(":min_quant", $min_quant);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$this->setLog($id_company, $id, $id_user, "edt");
	}	
	public function changeStatus($status, $id, $id_company)
	{
		$sql = "UPDATE sales SET status = :status WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);		
		$stmt->bindValue(":status", $status);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
	}
	public function getSalesFiltered($client_name, $period1, $period2, $status, $order, $id_company)
	{
		$array = array();

		$sql = "SELECT
				clients.name,
				sales.date_sale,
				sales.status,
				sales.total_price
				FROM sales 
				LEFT JOIN clients
				ON clients.id = sales.id_client
				WHERE ";
		$where = array();
		$where[] = "sales.id_company = :id_company";

		if (!empty($client_name)) {
			$where[] = "clients.name LIKE '%".$client_name."%'";
		}

		if (!empty($period1) && !empty($period2)) {
			$where[] = "sales.date_sale BETWEEN :period1 AND :period2";
		}

		if ($status != '') {
			$where[] = "sales.status = :status";
		}

		$sql .= implode(' AND ', $where);

		switch ($order) {
			case 'date_desc':
			default:
				$sql .= " ORDER BY sales.date_sale DESC";
				break;
			case 'date_asc':
				$sql .= " ORDER BY sales.date_sale ASC";
				break;
			case 'status':
				$sql .= " ORDER BY sales.status";
				break;		
			
		}

		// echo $sql;

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		
		if (!empty($period1) && !empty($period2)) {
			$stmt->bindValue(":period1", $period1);
			$stmt->bindValue(":period2", $period2);
		}
		if ($status != '') {
			$stmt->bindValue(":status", $status);
		}

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}

		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}

		return $array;
	}
	public function getTotalRevenue($period1, $period2, $id_company)
	{
		$float = 0;

		$sql = "SELECT SUM(total_price) AS total FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		$n = $stmt->fetch();
		$float = $n['total'];	

		return $float;
	}
	public function getTotalExpense($period1, $period2, $id_company)
	{
		$float = 0;

		$sql = "SELECT SUM(total_price) AS total FROM purchases WHERE id_company = :id_company AND date_purchase BETWEEN :period1 AND :period2";
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		$n = $stmt->fetch();
		$float = $n['total'];	

		return $float;
		
	}
	public function getSoldProducts($period1, $period2, $id_company)
	{
		$int = 0;
		// pega os id das vendas no periodo
		$sql = "SELECT id FROM sales WHERE id_company = :id_company AND date_sale BETWEEN :period1 AND :period2";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		// verifica resultado
		if ($stmt->rowCount() > 0) {
			// array para armazenar os ids
			$p = array();
			foreach ($stmt->fetchAll() as $sale_item) {
				$p[] = $sale_item['id'];
			}

			// contar os produtos na tabela vendas_produtos
			$sql = "SELECT COUNT(*) AS total 
					FROM sales_products 
					WHERE id_sale 
					IN (".implode(',', $p).")";
			$stmt = $this->db->query($sql);
			$n = $stmt->fetch();
			$int = $n['total'];
		}

		return $int;

	}
	public function getRevenueList($period1, $period2, $id_company)
	{
		$array = array();
		// PREENCHER O ARRAY
		$currentDay = $period1;
		while ($period2 != $currentDay) {
			$array[$currentDay] = 0;
			$currentDay = date( 'Y-m-d', strtotime('+1 day', strtotime($currentDay)) );
		}
		// LISTA DAS VENDAS AGRUPADAS POR DIA/MÊS E SUAS RESPECTIVAS SOMAS
		$sql = "SELECT DATE_FORMAT(date_sale, '%Y-%m-%d') AS date_sale,
				SUM(total_price) AS total
				FROM sales 
				WHERE id_company = :id_company 
				AND date_sale BETWEEN :period1 AND :period2
				GROUP BY DATE_FORMAT(date_sale, '%Y-%m-%d')";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			
			$rows = $stmt->fetchAll();

			foreach ($rows as $sale_item) {
				
				$array[$sale_item['date_sale']] = $sale_item['total'];
			}
		}

		return $array;
	}
	public function getExpensesList($period1, $period2, $id_company)
	{
		$array = array();
		// PREENCHER O ARRAY
		$currentDay = $period1;
		while ($period2 != $currentDay) {
			$array[$currentDay] = 0;
			$currentDay = date( 'Y-m-d', strtotime('+1 day', strtotime($currentDay)) );
		}
		// LISTA DAS VENDAS AGRUPADAS POR DIA/MÊS E SUAS RESPECTIVAS SOMAS
		$sql = "SELECT DATE_FORMAT(date_purchase, '%Y-%m-%d') AS date_purchase,
				SUM(total_price) AS total
				FROM purchases 
				WHERE id_company = :id_company 
				AND date_purchase BETWEEN :period1 AND :period2
				GROUP BY DATE_FORMAT(date_purchase, '%Y-%m-%d')";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			
			$rows = $stmt->fetchAll();

			foreach ($rows as $sale_item) {
				
				$array[$sale_item['date_purchase']] = $sale_item['total'];
			}
		}

		return $array;
	}
	public function getQuantStatusList($period1, $period2, $id_company)
	{
		$array = array('0' => 0, '1' => 0, '2' => 0);
			
		// LISTA DAS VENDAS AGRUPADAS POR STATUS E SUAS RESPECTIVAS SOMAS
		$sql = "SELECT COUNT(id)
				AS total, status
				FROM sales 
				WHERE id_company = :id_company 
				AND date_sale BETWEEN :period1 AND :period2
				GROUP BY status
				ORDER BY status DESC";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":period1", $period1);
		$stmt->bindValue(":period2", $period2);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			
			$rows = $stmt->fetchAll();

			foreach ($rows as $sale_item) {
				
				$array[$sale_item['status']] = $sale_item['total'];
			}
		}

		return $array;
	}
}