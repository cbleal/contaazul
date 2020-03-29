<h1>Compras</h1>
<?php if($add_permission): ?>
	<div class="button">
		<a href="<?php echo BASE_URL; ?>purchases/add">
			Adicionar Compra
		</a>
	</div>
<?php endif; ?>
<!-- <input type="text" id="busca" data-type="search_sales"> -->
<table border="0" width="100%">
	<tr>
		<th>Nome do Fornecedor</th>
		<th class="th-center">Data</th>
		<th class="th-center">Valor</th>
		<th class="th-center">Status</th>
		<th class="th-center">Ações</th>
	</tr>
	<?php foreach($purchases_list as $purchase_item): ?>
		<tr>
			<!-- NOME -->
			<td>
				<?php echo $purchase_item['name']; ?>					
			</td>
			<!-- DATA -->
			<td width="140" class="td-center">
				<?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?>
			</td>
			<!-- VALOR -->
			<td width="140" class="td-center">
				R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?>
			</td>
			<!-- STATUS -->
			<td width="140" class="td-center">
				<?php echo $statuses[$purchase_item['status']]; ?>
			</td>
			<!-- AÇÕES -->
			<td width="140" class="td-center">
				<div class="button button_small">
					<a href="<?php echo BASE_URL; ?>purchases/edit/<?php echo $purchase_item['id']; ?>">
						Editar
					</a>
				</div>
				<!-- <div class="button button_small">
					<a href="<?php echo BASE_URL; ?>sales/delete/<?php echo $purchase_item['id'] ?>" onclick="return confirm('Deseja Realmente Excluir ?')">
						Excluir
					</a>
				</div> -->
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="pagination">
	<?php for ($q=1; $q<=$num_paginas; $q++): ?>
		<div class="pag_item <?php echo ($q == $pagina_atual)?'pag_ativo':'' ; ?>">
			<a href="<?php echo BASE_URL; ?>purchases?p=<?php echo $q; ?>">
				<?php echo $q; ?>
			</a>
		</div>
	<?php endfor; ?>
</div>
