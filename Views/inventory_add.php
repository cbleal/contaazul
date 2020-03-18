<h1>Produtos - Adicionar</h1>
<form method="POST">
	<!-- NOME -->
	<label for="name">Nome</label><br>
	<input type="text" name="name" required><br><br>
	<!-- PREÇO -->
	<label for="price">Preço</label><br>	
	<input type="text" name="price" required><br><br>
	<!-- QUANTIDADE -->
	<label for="quant">Quantidade</label><br>
	<input type="number" name="quant" required><br><br>
	<!-- QUANTIDADE MÍNIMA -->
	<label for="min_quant">Qtde Mínima</label><br>
	<input type="number" name="min_quant" required><br>	
	<!-- BOTÃO -->
	<input type="submit" value="Adicionar">	
</form>
<!-- JQUERY MASK -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
<!-- SCRIPT INVENTORY ADD -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_inventory_add.js"></script>
