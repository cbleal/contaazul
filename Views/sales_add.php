<h1>Vendas - Adicionar</h1>
<form method="POST">
	<!-- ID -->
	<input type="hidden" name="client_id">
	<!-- NOME -->
	<label for="client_name">Nome do Cliente</label><br>
	<input type="text" name="client_name" id="client_name" data-type="search_clients">
	<button class="client_add_button">+</button>
	<div style="clear:both"></div>
	<br><br>
	<!-- VALOR -->
	<label for="total_price">Valor da Venda</label>
	<input type="text" name="total_price" disabled="disable"><br><br>
	<!-- STATUS -->
	<label for="status">Status da Venda</label><br>
	<select name="status" id="status">
		<option value="0">Aguardando Pgto</option>
		<option value="1">Pago</option>
		<option value="2">Cancelado</option>
	</select><br><br>
	<hr>
	<fieldset>
		<legend>Adicionar Produto</legend>
		<input type="text" id="add_prod" data-type="search_products">
	</fieldset>
	<table id="product_table" border="0" width="100%">
		<tr>
			<th>Nome do Produto</th>
			<th>Qtde</th>
			<th>Preço Unitário</th>
			<th>Sub-Total</th>
			<th>Ações</th>
		</tr>
	</table>
	<hr>
	<!-- BOTÃO -->
	<input type="submit" value="Adicionar Venda">
</form>
<!-- JQUERY MASK -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
<!-- SCRIPT SALES ADD -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_sales_add.js"></script>
