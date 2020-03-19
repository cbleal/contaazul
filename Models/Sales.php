<?php
namespace Models;
use \Core\Model;

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
		$sql = "SELECT * FROM inventory WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetch();
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
	public function add($id_company, $id_client, $id_user, $total_price, $status)
	{
		$sql = "INSERT INTO sales SET id_company = :id_company, id_client = :id_client, id_user = :id_user, date_sale = NOW(), total_price = :total_price, status = :status";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id_client", $id_client);
		$stmt->bindValue(":id_user", $id_user);
		$stmt->bindValue(":total_price", $total_price);
		$stmt->bindValue(":status", $status);
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
	public function delete($id, $id_company, $id_user)
	{
		$sql = "DELETE FROM inventory WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);		
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$this->setLog($id_company, $id, $id_user, "del");
	}
}