<h1>Fornecedores</h1>
<?php if ($edit_permission): ?>
	<div class="button">
		<a href="<?php echo BASE_URL; ?>/providers/add">
			Adicionar Fornecedor
		</a>
	</div>	
<?php endif; ?>
<input type="text" id="busca" data-type="search_providers">
<table border="0" width="100%">
	<tr>
		<th>Nome</th>
		<th>Telefone</th>
		<th>Cidade</th>
		<th>Estrelas</th>
		<th class="th-center">Ações</th>
	</tr>
	<?php foreach ($providers_list as $p):?>	
		<tr>			
			<td><?php echo $p['name']; ?></td>				
			<td width="100"><?php echo $p['phone']; ?></td>				
			<td width="150"><?php echo $p['address_city']; ?></td>				
			<td width="70" style="text-align: center;"><?php echo $p['stars']; ?></td>				
			<td width="160" class="td-center">
				<?php if ($edit_permission): ?>
					<!-- BOTÃO EDITAR -->
					<div class="button button_small">
						<a href="<?php echo BASE_URL; ?>/providers/edit/<?php echo $p['id']; ?>">
							Editar
						</a>
					</div>
					<!-- BOTÃO EXCLUIR -->
					<div class="button button_small">
						<a href="<?php echo BASE_URL; ?>/providers/delete/<?php echo $p['id']; ?>" onclick="return confirm('Deseja Realmente Excluir ?')">
							Excluir
						</a>
					</div>
				<?php else: ?>
						<!-- BOTÃO VISUALIZAR -->
					<div class="button button_small">
						<a href="<?php echo BASE_URL; ?>/providers/view/<?php echo $p['id']; ?>">
							Visualizar
						</a>
					</div>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="pagination">
	<?php for($q = 1; $q <= $p_count; $q++): ?>
		<div class="pag_item <?php echo ($q == $p)?'pag_ativo':''; ?>">
			<a href="<?php echo BASE_URL; ?>providers?p=<?php echo $q; ?>">
				<?php echo $q; ?>
			</a>
		</div>
	<?php endfor; ?>
	<div style="clear: both;"></div>
</div>
