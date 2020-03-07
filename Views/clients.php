<h1>Clientes</h1>
<?php if ($edit_permission): ?>
	<div class="button">
		<a href="<?php echo BASE_URL; ?>/clients/add">
			Adicionar Cliente
		</a>
	</div>	
<?php endif; ?>
<table border="0" width="100%">
	<tr>
		<th>Nome</th>
		<th>Telefone</th>
		<th>Cidade</th>
		<th>Estrelas</th>
		<th style="text-align: center;">Ações</th>
	</tr>
	<?php foreach ($clients_list as $c):?>	
		<tr>			
			<td><?php echo $c['name']; ?></td>				
			<td width="100"><?php echo $c['phone']; ?></td>				
			<td width="150"><?php echo $c['address_city']; ?></td>				
			<td width="70" style="text-align: center;"><?php echo $c['stars']; ?></td>				
			<td width="160" style="text-align: center;">
				<?php if ($edit_permission): ?>
					<!-- BOTÃO EDITAR -->
					<div class="button button_small"><a href="<?php echo BASE_URL; ?>/clients/edit/<?php echo $c['id']; ?>">Editar</a></div>
					<!-- BOTÃO EXCLUIR -->
					<div class="button button_small"><a href="<?php echo BASE_URL; ?>/clients/delete/<?php echo $c['id']; ?>" onclick="return confirm('Deseja Realmente Excluir ?')">Excluir</a></div>
				<?php else: ?>
						<!-- BOTÃO VISUALIZAR -->
					<div class="button button_small"><a href="<?php echo BASE_URL; ?>/clients/view/<?php echo $c['id']; ?>">Visualizar</a></div>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>