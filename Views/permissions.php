<h1>Permissões</h1>
<div class="tabarea">
	<div class="tabitem activetab">Grupos de Permissões</div>
	<div class="tabitem">Permissões</div>
</div>
<div class="tabcontent">
	<div class="tabbody" style="display: block;">
		<!-- GRUPO DE PERMISSÕES -->
		<div class="button">
			<a href="<?php echo BASE_URL; ?>/permissions/add_group">
				Adicionar Grupo de Permissões
			</a>
		</div>
		<table border="0" width="100%">
			<tr>
				<th>Nome do Grupo de Permissões</th>
				<th class="th-center">Ações</th>
			</tr>
			<?php foreach ($permissions_group_list as $p):?>	
				<tr>			
					<td><?php echo $p['name']; ?></td>					
					<td width="160" class="td-center">
						<!-- BOTÃO EDITAR -->
						<div class="button button_small">
							<a href="<?php echo BASE_URL; ?>/permissions/edit_group/<?php echo $p['id']; ?>">
								Editar
							</a>
						</div>
						<!-- BOTÃO EXCLUIR -->
						<div class="button button_small">
							<a href="<?php echo BASE_URL; ?>/permissions/delete_group/<?php echo $p['id']; ?>" onclick="return confirm('Deseja Realmente Excluir ?')">
								Excluir
							</a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="tabbody">
		<!-- PERMISSÕES -->
		<div class="button">
			<a href="<?php echo BASE_URL; ?>/permissions/add">Adicionar Permissão</a>
		</div>
		<table border="0" width="100%">
			<tr>
				<th>Nome da Permissão</th>
				<th class="th-center">Ações</th>
			</tr>
			<?php foreach ($permissions_list as $p):?>	
				<tr>			
					<td><?php echo $p['name']; ?></td>
					<td width="100" class="td-center">
						<div class="button button_small">
							<a href="<?php echo BASE_URL; ?>/permissions/delete/<?php echo $p['id']; ?>" onclick="return confirm('Deseja Realmente Excluir ?')">
								Excluir
							</a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

		<!-- PAGINATION -->
		<div class="pagination">
			<?php for ($q=1; $q<=$num_pages;$q++): ?>
				<div class="pag_item <?php echo ($q == $page)?'pag_ativo':''; ?>">
					<a href="<?php BASE_URL; ?>permissions?p=<?php echo $q; ?>">
						<?php echo $q; ?>
					</a>
				</div>
			<?php endfor;?>
			<div style="clear: both;"></div>
		</div>

	</div>
</div>

