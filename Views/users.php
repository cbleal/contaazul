<h1>Usuários</h1>
<div class="button">
	<a href="<?php echo BASE_URL; ?>/users/add">
		Adicionar Usuário
	</a>
</div>
<table border="0" width="100%">
	<tr>
		<th>E-mail</th>
		<th>Nome do Grupo</th>
		<th>Ações</th>
	</tr>
	<?php foreach ($users_list as $u):?>	
		<tr>			
			<td><?php echo $u['email']; ?></td>				
			<td><?php echo $u['name']; ?></td>				
			<td width="160">
				<!-- BOTÃO EDITAR -->
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>/users/edit/<?php echo $u['id']; ?>">Editar</a></div>
				<!-- BOTÃO EXCLUIR -->
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>/users/delete/<?php echo $u['id']; ?>" onclick="return confirm('Deseja Realmente Excluir ?')">Excluir</a></div>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
