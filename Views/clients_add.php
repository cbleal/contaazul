<!-- CSS -->
<style>
	select {
		width: 1123px;
	}
</style>

<h1>Clientes - Adicionar</h1>
<div class="form">
<form method="POST">
	<!-- NOME -->
	<label for="name">Nome</label><br>
	<input type="text" name="name" required><br><br>
	<!-- EMAIL -->
	<label for="email">Email</label><br>
	<input type="email" name="email"><br><br>
	<!-- TELEFONE -->
	<label for="phone">Telefone</label><br>
	<input type="text" name="phone" id="phone"><br><br>
	<!-- CEP -->
	<label for="address_zipcode">CEP</label><br>
	<input type="text" name="address_zipcode" minlength="8" maxlength="8" onkeypress="$(this).mask('00.000-000')"><br><br>
	<!-- ENDEREÇO -->
	<label for="address">Endereço</label><br>
	<input type="text" name="address"><br><br>
	<!-- NÚMERO -->
	<label for="address_number">Número</label><br>
	<input type="text" name="address_number"><br><br>
	<!-- COMPLEMENTO -->
	<label for="address2">Complemento</label><br>
	<input type="text" name="address2"><br><br>
	<!-- BAIRRO -->
	<label for="address_neighb">Bairro</label><br>
	<input type="text" name="address_neighb"><br><br>
	<!-- ESTADO -->
	<label for="address_state">Estado</label><br>
	<input type="text" name="address_state"><br><br>
	<!-- CIDADE -->
	<label for="address_city">Cidade</label><br>
	<input type="text" name="address_city"><br><br>
	<!-- PAÍS -->
	<label for="address_country">País</label><br>
	<input type="text" name="address_country"><br><br>
	<!-- ESTRELAS -->	
	<label for="stars">Estrelas</label><br>
	<select name="stars" id="stars">
		<option value="1">1 Estrela</option>
		<option value="2">2 Estrelas</option>
		<option value="3" selected="selected">3 Estrelas</option>
		<option value="4">4 Estrelas</option>
		<option value="5">5 Estrelas</option>
	</select><br><br>
	<!-- OBSERVAÇÕES -->
	<label for="internal_obs">Observações</label><br>
	<textarea name="internal_obs" id="internal_obs"></textarea><br>
	<!-- BOTÃO -->
	<input type="submit" value="Adicionar">
</form>
</div>

<!-- JQUERY MASK -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
<!-- JAVASCRIPT -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_clients_add.js"></script>
