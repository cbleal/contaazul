<?php
require 'environment.php';

$config = array();

if (ENVIRONMENT == 'development') {
	// define("BASE_URL", "http://localhost/contaazul/");
	$config['name'] = "pdo";
	$config['host'] = "localhost";
	$config['user'] = "root";
	$config['pass'] = "";
}
else {
	// define("BASE_URL", "www.meusite.com");
	$config['name'] = "localhost";
	$config['host'] = "localhost";
	$config['user'] = "root";
	$config['pass'] = "";
}

global $db;

try {
	$db = new PDO("mysql:dbname=".$config['name'].";host=".$config['host'], $config['user'], $config['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}