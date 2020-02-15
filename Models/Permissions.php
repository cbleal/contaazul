<?php
namespace Models;
use \Core\Model;

class Permissions extends Model
{
	private $group;
	private $permissions;

	public function setGroup($id, $id_company)
	{
		$this->group = $id;
		$this->permissions = array();

		$sql = "SELECT params FROM permission_groups WHERE id = :id AND id_company = :id_company";
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

			$sql = "SELECT name FROM permission_params WHERE id IN($params) AND id_company = :id_company";
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
}