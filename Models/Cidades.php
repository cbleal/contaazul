<?php

namespace Models;
use \Core\Model;

class Cidades extends Model
{
	
	function getListStates()
	{
		$array = array();

		$sql = "SELECT IdEstado, Uf FROM cidades GROUP BY Uf";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}

		return $array;
	}
	function getListCities($state)
	{
		$array = array();
		
		$sql = "SELECT CodigoMunicipio, Nome FROM cidades WHERE Uf = :uf";		
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":uf", $state);		
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$array = $stmt->fetchAll();
		}

		return $array;
	}
	public function getCity($city_code) 
	{			
		$sql = "SELECT Nome FROM cidades WHERE CodigoMunicipio = :codigo";		
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":codigo", $city_code);		
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$res = $stmt->fetch();
			$city = $res['Nome'];
			return $city;
		}
		
	}
}