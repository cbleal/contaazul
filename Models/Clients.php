<?php
namespace Models;
use \Core\Model;

class Clients extends Model
{
	public function getList($offset, $id_company)
	{
		$array = array();
		$sql = "SELECT * FROM clients WHERE id_company = :id_company LIMIT $offset,10";
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
		$sql = "SELECT * FROM clients WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);	
		$stmt->bindValue(":id_company", $id_company);	
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetch();
		}

		return $array;
	}
	public function getCount($id_company)
	{
		$r = 0;
		$sql = "SELECT COUNT(*) AS c FROM clients WHERE id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$row = $stmt->fetch();		
		$r = $row['c'];
		// var_dump($r); exit;

		return $r;
	}
	public function add($name, $email, $phone, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $stars, $internal_obs, $id_company)
	{
		$sql = "INSERT INTO clients SET name = :name, email = :email, phone = :phone, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_neighb = :address_neighb, address_city = :address_city, address_state = :address_state, address_country = :address_country, stars = :stars, internal_obs = :internal_obs, id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":email", $email);
		$stmt->bindValue(":phone", $phone);
		$stmt->bindValue(":address_zipcode", $address_zipcode);
		$stmt->bindValue(":address", $address);
		$stmt->bindValue(":address_number", $address_number);
		$stmt->bindValue(":address2", $address2);
		$stmt->bindValue(":address_neighb", $address_neighb);
		$stmt->bindValue(":address_city", $address_city);
		$stmt->bindValue(":address_state", $address_state);
		$stmt->bindValue(":address_country", $address_country);
		$stmt->bindValue(":stars", $stars);
		$stmt->bindValue(":internal_obs", $internal_obs);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
	}	
	public function edit($id, $name, $email, $phone, $address_zipcode, $address, $address_number, $address2, $address_neighb, $address_city, $address_state, $address_country, $stars, $internal_obs, $id_company)
	{
		$sql = "UPDATE clients SET name = :name, email = :email, phone = :phone, address_zipcode = :address_zipcode, address = :address, address_number = :address_number, address2 = :address2, address_neighb = :address_neighb, address_city = :address_city, address_state = :address_state, address_country = :address_country, stars = :stars, internal_obs = :internal_obs, id_company = :id_company WHERE id = :id AND id_company = :id_company2";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":email", $email);
		$stmt->bindValue(":phone", $phone);
		$stmt->bindValue(":address_zipcode", $address_zipcode);
		$stmt->bindValue(":address", $address);
		$stmt->bindValue(":address_number", $address_number);
		$stmt->bindValue(":address2", $address2);
		$stmt->bindValue(":address_neighb", $address_neighb);
		$stmt->bindValue(":address_city", $address_city);
		$stmt->bindValue(":address_state", $address_state);
		$stmt->bindValue(":address_country", $address_country);
		$stmt->bindValue(":stars", $stars);
		$stmt->bindValue(":internal_obs", $internal_obs);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company2", $id_company);
		$stmt->execute();
	}
	public function searchClientByName($name, $id_company)
	{
		$array = array();
		$sql = "SELECT id, name FROM clients WHERE name LIKE :name AND id_company = :id_company LIMIT 10";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", "%".$name."%");
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}

		return $array;
	}
}
