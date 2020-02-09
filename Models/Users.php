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
}
