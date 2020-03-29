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
		<th class="th-center">Data</th>
		<th class="th-center">Valor</th>
		<th class="th-center">Status</th>
		<th class="th-center">Ações</th>
	</tr>
	<?php foreach($sales_list as $sale_item): ?>
		<tr>
			<!-- NOME -->
			<td>
				<?php echo $sale_item['name']; ?>					
			</td>
			<!-- DATA -->
			<td width="140" class="td-center">
				<?php echo date('d/m/Y', strtotime($sale_item['date_sale'])); ?>
			</td>
			<!-- VALOR -->
			<td width="140" class="td-center">
				R$ <?php echo number_format($sale_item['total_price'], 2, ',', '.'); ?>
			</td>
			<!-- STATUS -->
			<td width="140" class="td-center">
				<?php echo $statuses[$sale_item['status']]; ?>
			</td>
			<!-- AÇÕES -->
			<td width="140" class="td-center">
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

<div class="pagination">
	<?php for ($q=1; $q<=$num_paginas; $q++): ?>
		<div class="pag_item <?php echo ($q = $pagina_atual)?'pag_ativo':'' ?>">
			<a href="<?php echo BASE_URL; ?>sales?p=<?php echo $q; ?>">
				<?php echo $q; ?>
			</a>
		</div>
	<?php endfor; ?>
</div>
