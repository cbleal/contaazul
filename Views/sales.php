<h1>Vendas</h1>
<?php if($add_permission): ?>
	<div class="button">
		<a href="<?php echo BASE_URL; ?>sales/add">
			Adicionar Venda
		</a>
	</div>
<?php endif; ?>
<!-- <input type="text" id="busca" data-type="search_sales"> -->
<table border="0" width="100%">
	<tr>
		<th>Nome do Cliente</th>
		<th>Data</th>
		<th>Valor</th>
		<th>Status</th>
		<th>Ações</th>
	</tr>
	<?php foreach($sales_list as $sale_item): ?>
		<tr>
			<td>
				<?php echo $sale_item['name']; ?>					
			</td>
			<td>
				<?php echo date('d/m/Y', strtotime($sale_item['date_sale'])); ?>
			</td>
			<td>
				R$ <?php echo number_format($sale_item['total_price'], 2, ',', '.'); ?>
			</td>
			<td width="140">
				<?php echo $statuses[$sale_item['status']]; ?>
			</td>
			<td width="140" style="text-align:center">
				<div class="button button_small">
					<a href="<?php echo BASE_URL; ?>sales/edit/<?php echo $sale_item['id']; ?>">
						Editar
					</a>
				</div>
				<!-- <div class="button button_small">
					<a href="<?php echo BASE_URL; ?>sales/delete/<?php echo $sale_item['id'] ?>" onclick="return confirm('Deseja Realmente Excluir ?')">
						Excluir
					</a>
				</div> -->
			</td>
		</tr>
	<?php endforeach; ?>
</table>
