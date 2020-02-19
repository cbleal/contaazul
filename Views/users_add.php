<h1>Usuários - Adicionar</h1>
<?php if (isset($error_msg) && !empty($error_msg)): ?>
	<div class="warn">
		<?php echo $error_msg; ?>
	</div>
<?php endif; ?>
<form method="POST">
	<label for="email">Email</label><br>
	<input type="email" name="email" required><br><br>

	<label for="password">Senha</label><br>
	<input type="password" name="password" required><br><br>

	<label>Grupo de Permissões</label><br>	
	<select name="group" id="group">
		<?php foreach ($users_group_list as $g): ?>			
			<option value="<?php echo $g['id'];?>"><?php echo $g['name'];?></option>
		<?php endforeach; ?>
	</select>

	<input type="submit" value="Adicionar">
</form>