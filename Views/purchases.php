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
		<th>Data</th>
		<th>Valor</th>
		<th>Status</th>
		<th>Ações</th>
	</tr>
	<?php foreach($purchases_list as $purchase_item): ?>
		<tr>
			<td>
				<?php echo $purchase_item['name']; ?>					
			</td>
			<td>
				<?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?>
			</td>
			<td>
				R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?>
			</td>
			<td width="140">
				<?php echo $statuses[$purchase_item['status']]; ?>
			</td>
			<td width="140" style="text-align:center">
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
