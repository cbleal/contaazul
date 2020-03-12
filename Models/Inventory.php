<?php
namespace Models;
use \Core\Model;

class Inventory extends Model
{	
	public function getList($offset, $id_company)
	{
		$array = array();
		$sql = "SELECT * FROM inventory WHERE id_company = :id_company 
				LIMIT $offset,10";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}
		
		return $array;
	}
	public function add($name, $price, $quant, $min_quant, $id_company, $id_user)
	{
		$sql = "INSERT INTO inventory SET name = :name, price = :price, quant = :quant, min_quant = :min_quant, id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":price", $price);
		$stmt->bindValue(":quant", $quant);
		$stmt->bindValue(":min_quant", $min_quant);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$id_product = $this->db->lastInsertId();
		$sql = "INSERT INTO inventory_history SET id_company = :id_company, id_product = :id_product, id_user = :id_user, action = :action, date_action = NOW()";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id_product", $id_product);
		$stmt->bindValue(":id_user", $id_user);
		$stmt->bindValue(":action", "add");
		$stmt->execute();
	}
}