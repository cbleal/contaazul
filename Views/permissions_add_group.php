<h1>Permissões - Adicionar Grupos de Permissões</h1>
<form method="POST">
	<label for="name">Nome do Grupo de Permissões</label><br>
	<input type="text" name="name"><br><br>
	<label>Permissões</label><br>
	<?php foreach ($permissions_list as $p): ?>
		<div class="p_item">
			<!-- CHECKBOX -->
			<input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id="p_<?php echo $p['id']; ?>"/>
			<label for="p_<?php echo $p['id']; ?>"><?php echo $p['name']; ?></label>
		</div>
	<?php endforeach; ?>
	<input type="submit" value="Adicionar">
</form>
