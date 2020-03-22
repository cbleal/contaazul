<?php
namespace Models;
use \Core\Model;
use \Models\Inventory;

class Purchases extends Model
{	
	public function getList($offset, $id_company)
	{
		$array = array();
		$sql = "SELECT
					pu.id,
					pr.name,
					pu.date_purchase,
					pu.total_price,
					pu.status
				FROM purchases AS pu
				LEFT JOIN providers AS pr
				ON pr.id = pu.id_provider
				WHERE pu.id_company = :id_company
				ORDER BY pu.date_purchase DESC
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

		// INFORMAÇÕES DA COMPRA E NOME DO FORNECEDOR
		$sql = "SELECT *,
				( SELECT providers.name FROM providers WHERE providers.id = purchases.id_provider ) AS provider_name 
				FROM purchases 
				WHERE 
				id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$array['info'] = $stmt->fetch();
		}

		// INFORMAÇÕES DOS PRODUTOS DA COMPRA E NOME DO PRODUTO
		$sql = "SELECT 
				purchases_products.quant,
				purchases_products.purchase_price,
				inventory.name 
				FROM purchases_products 
				LEFT JOIN inventory ON inventory.id = purchases_products.id_product 
				WHERE purchases_products.id_purchase = :id_purchase 
				AND purchases_products.id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_purchase", $id);
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
	public function addPurchase($id_company, $id_provider, $id_user, $quant, $status)
	{
		$i = new Inventory();

		// ADICIONAR A COMPRA
		$sql = "INSERT INTO purchases SET id_company = :id_company, id_provider = :id_provider, id_user = :id_user, date_purchase = NOW(), total_price = :total_price, status = :status";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id_provider", $id_provider);
		$stmt->bindValue(":id_user", $id_user);
		$stmt->bindValue(":total_price", 0); // ADD TOTAL_PRICE = 0
		$stmt->bindValue(":status", $status);
		$stmt->execute();

		// ID DA VENDA
		$id_purchase = $this->db->lastInsertId();

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
				$sqlp = "INSERT INTO purchases_products SET id_company = :id_company, id_purchase = :id_purchase, id_product = :id_product, quant = :quant, purchase_price = :purchase_price";
				$stmtp = $this->db->prepare($sqlp);
				$stmtp->bindValue(":id_company", $id_company);
				$stmtp->bindValue(":id_purchase", $id_purchase);
				$stmtp->bindValue(":id_product", $id_prod);
				$stmtp->bindValue(":quant", $quant_prod);
				$stmtp->bindValue(":purchase_price", $price);
				$stmtp->execute();

				// DAR ENTRADA NO ESTOQUE (INVENTORY)
				$i->increase($id_prod, $id_company, $quant_prod, $id_user);

				$total_price += $price * $quant_prod;
			}
		}

		// ATUALIZAR O CAMPO TOTAL_PRICE NA TABELA PURCHASES
		$sql = "UPDATE purchases SET total_price = :total_price WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":total_price", $total_price);
		$stmt->bindValue(":id", $id_purchase);
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
		$sql = "UPDATE purchases SET status = :status WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);		
		$stmt->bindValue(":status", $status);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
	}
}