<h3>Lista de Usuários</h3>

<?php
foreach ($lista as $item) {
	echo "NOME: ".$item['name']." | EMAIL: ".$item['email'];
	echo "<hr>";
}
