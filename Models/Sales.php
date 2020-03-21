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
}