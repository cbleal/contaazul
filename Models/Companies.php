<?php
namespace Models;
use \Core\Model;
class Companies extends Model
{
	private $companyInfo;

	public function __construct($id)
	{
		parent::__construct();
		$sql = "SELECT * FROM companies WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":id", $id);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$this->companyInfo = $stmt->fetch();
		}
	}
	public function getName()
	{
		if (isset($this->companyInfo['name'])) {
			return $this->companyInfo['name'];
		}
		else {
			return '';
		}
	}
}
