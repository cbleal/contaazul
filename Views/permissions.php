<h1>Permissões</h1>
<div class="tabarea">
	<div class="tabitem activetab">Grupos de Permissões</div>
	<div class="tabitem">Permissões</div>
</div>
<div class="tabcontent">
	<div class="tabbody" style="display: block;">
		GRUPOS DE PERMISSÕES
	</div>
	<div class="tabbody">
		<div class="button"><a href="<?php echo BASE_URL; ?>/permissions/add">Adicionar Permissão</a></div>
		<table border="0" width="100%">
			<tr>
				<th>Nome da Permissão</th>
				<th>Ações</th>
			</tr>
			<?php foreach ($permissions_list as $p):?>	
				<tr>			
					<td><?php echo $p['name']; ?></td>
					<td width="100"><div class="button button_small"><a href="<?php echo BASE_URL; ?>/permissions/delete/<?php echo $p['id']; ?>">Excluir</a></div></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>