<?php
namespace Models;
use \Core\Model;

class Users extends Model
{
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
}
