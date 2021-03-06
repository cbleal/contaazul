<?php
namespace Models;
use \Core\Model;
use \Models\Users;

class Permissions extends Model
{
	private $group;
	private $permissions;

	public function setGroup($id, $id_company)
	{
		$this->group = $id;
		$this->permissions = array();

		$sql = "SELECT params 
				FROM permission_groups 
				WHERE id = :id 
				AND id_company = :id_company";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {

			$row = $stmt->fetch();				
			if (empty($row['params'])) {
				$row['params'] = 0;
			}

			$params = $row['params'];

			$sql = "SELECT name 
					FROM permission_params 
					WHERE id IN($params) 
					AND id_company = :id_company";

			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":id_company", $id_company);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {

				foreach ($stmt->fetchAll() as $item) {
					$this->permissions[] = $item['name'];
				}
			}
		}		
	}
	public function hasPermission($name)
	{
		if (in_array($name, $this->permissions)) {

			return true;
		} else {

			return false;
		}
	}
	public function getList($offset, $id_company)
	{
		$array = array();

		$sql = "SELECT * 
				FROM permission_params 
				WHERE id_company = :id_company 
				LIMIT $offset,10";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {

			$array = $stmt->fetchAll();
		}

		return $array;
	}
	public function getGroupList($id_company)
	{
		$array = array();

		$sql = "SELECT * 
				FROM permission_groups 
				WHERE id_company = :id_company";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {

			$array = $stmt->fetchAll();
		}

		return $array;
	}
	public function getGroup($id)
	{
		$array = array();

		$sql = "SELECT * 
				FROM permission_groups 
				WHERE id = :id";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {

			$array = $stmt->fetch();
			$array['params'] = explode(',', $array['params']);
		}

		return $array;
	}	
	public function getCount($id_company)
	{
		$r = 0;

		$sql = "SELECT 
				COUNT(*) AS c 
				FROM permission_params 
				WHERE id_company = :id_company";
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		$row = $stmt->fetch();
		$r = $row['c'];

		return $r;

	}
	public function add($name, $id_company)
	{
		$sql = "INSERT INTO permission_params 
				SET name = :name, id_company = :id_company";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
	}
	public function addGroup($name, $list, $id_company)
	{
		$params = implode(',', $list);

		$sql = "INSERT INTO permission_groups 
				SET name = :name, id_company = :id_company, 	params = :params";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":params", $params);
		$stmt->execute();
	}	
	public function delete($id)
	{
		$sql = "DELETE FROM permission_params WHERE id = :id";

		$stmt = $this->db->prepare($sql);		
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
	public function deleteGroup($id)
	{
		$u = new Users();

		if (!$u->findUsersInGroup($id)) {	

			$sql = "DELETE FROM permission_groups WHERE id = :id";

			$stmt = $this->db->prepare($sql);		
			$stmt->bindValue(":id", $id);
			$stmt->execute();
		}
	}
	public function editGroup($name, $list, $id, $id_company)
	{
		$params = implode(',', $list);

		$sql = "UPDATE permission_groups 
				SET name = :name, id_company = :id_company, params = :params 
				WHERE id = :id";
				
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":name", $name);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->bindValue(":params", $params);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
	}
	
}