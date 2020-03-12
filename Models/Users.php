<?php
namespace Models;
use \Core\Model;
use \Models\Permissions;

class Users extends Model
{
	private $userInfo;
	private $permissions;

	public function isLogged()
	{
		if (isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			return true;
		} else {
			return false;
		}
	}
	public function doLogin($email, $password)
	{
		$sql = "SELECT * FROM users WHERE email = :email AND password = :password";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":email", $email);
		$stmt->bindValue(":password", md5($password));
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch();
			$_SESSION['ccUser'] = $row['id'];
			return true;
		}
		else {
			return false;
		}
	}
	public function setLoggedUser()
	{
		if (isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
			$id = addslashes($_SESSION['ccUser']);

			$sql = "SELECT * FROM users WHERE id = :id";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":id", $id);
			$stmt->execute();

			if ($stmt->rowCount()) {
				$this->userInfo = $stmt->fetch();

				$this->permissions = new Permissions();
				$this->permissions->setGroup($this->userInfo['id_group'], $this->userInfo['id_company']);
			}
		}
	}
	public function hasPermission($name)
	{
		return $this->permissions->hasPermission($name);
	}
	public function getId()
	{
		if (isset($this->userInfo['id'])) {
			return $this->userInfo['id'];
		}
		else {
			return 0;
		}
	}
	public function getCompany()
	{
		if (isset($this->userInfo['id_company'])) {
			return $this->userInfo['id_company'];
		}
		else {
			return 0;
		}
	}
	public function getEmail()
	{
		if (isset($this->userInfo['email'])) {
			return $this->userInfo['email'];
		}
		else {
			return '';
		}
	}
	public function logout()
	{
		unset($_SESSION['ccUser']);
	}
	public function findUsersInGroup($id)
	{
		$sql = "SELECT COUNT(*) AS c FROM users WHERE id_group = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->execute();
		$row = $stmt->fetch();

		if ($row['c'] == 0) {
			return false;
		} else {
			return true;
		}
	}
	public function getList($id_company)
	{
		$array = array();
		$sql = "SELECT users.id, users.email, permission_groups.name
				FROM users LEFT JOIN permission_groups
				ON permission_groups.id = users.id_group
				WHERE users.id_company = :id_company";
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
		$sql = "SELECT * FROM users WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetch();
		}
		return $array;
	}
	public function add($email, $password, $id_group, $id_company)
	{
		// verificar se usuário já existe com este email nesta company
		$sql = "SELECT COUNT(*) AS c FROM users WHERE email = :email";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":email", $email);
		$stmt->execute();

		$row = $stmt->fetch();

		if ($row['c'] == 0) { // não encontrou
			// add	
			$sql = "INSERT INTO users SET email = :email, password = :password, id_group = :id_group, id_company = :id_company";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":password", md5($password));
			$stmt->bindValue(":id_group", $id_group);
			$stmt->bindValue(":id_company", $id_company);
			$stmt->execute();

			return '1';
		}
		else {
			return '0';
		}
	}
	public function edit($password, $id_group, $id, $id_company)
	{
		$sql = "UPDATE users SET id_group = :id_group WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id_group", $id_group);
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
		// verificar password
		if (isset($password) && !empty($password)) {
			$sql = "UPDATE users SET password = :password WHERE id = :id AND id_company = :id_company";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":password", md5($password));
			$stmt->bindValue(":id", $id);
			$stmt->bindValue(":id_company", $id_company);
			$stmt->execute();
		}
	}
	public function delete($id, $id_company)
	{
		$sql = "DELETE FROM users WHERE id = :id AND id_company = :id_company";
		$stmt = $this->db->prepare($sql);	
		$stmt->bindValue(":id", $id);
		$stmt->bindValue(":id_company", $id_company);
		$stmt->execute();
	}
}
