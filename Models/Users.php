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
}
