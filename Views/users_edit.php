<h1>Usuários - Editar</h1>
<form method="POST">
	<label for="email">Email</label><br>
	<input type="email" name="email" value="<?php echo $user_info['email']; ?>" disabled><br><br>

	<label for="password">Senha</label><br>
	<input type="password" name="password"><br><br>

	<label>Grupo de Permissões</label><br>	
	<select name="group" id="group">
		<?php foreach ($users_group_list as $g): ?>			
			<option value="<?php echo $g['id'];?>" <?php echo ($g['id'] == $user_info['id_group'])?'selected="selected"':'' ?>><?php echo $g['name'];?></option>
		<?php endforeach; ?>
	</select>

	<input type="submit" value="Salvar">
</form>