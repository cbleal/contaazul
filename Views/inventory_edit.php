<h1>Produtos - Editar</h1>
<form method="POST">
	<!-- NOME -->
	<label for="name">Nome</label><br>
	<input type="text" name="name" value="<?php echo $inventory_info['name']; ?>" required><br><br>
	<!-- PREÇO -->
	<label for="price">Preço</label><br>	
	<input type="text" name="price" value="<?php echo number_format($inventory_info['price'], 2); ?>" required><br><br>
	<!-- QUANTIDADE -->
	<label for="quant">Quantidade</label><br>
	<input type="number" name="quant" value="<?php echo $inventory_info['quant']; ?>" required><br><br>
	<!-- QUANTIDADE MÍNIMA -->
	<label for="min_quant">Qtde Mínima</label><br>
	<input type="number" name="min_quant" value="<?php echo $inventory_info['min_quant']; ?>" required><br>	
	<!-- BOTÃO -->
	<input type="submit" value="Salvar">	
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_inventory_add.js"></script>
