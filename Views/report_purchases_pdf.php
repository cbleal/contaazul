<style type="text/css">
	th {
		text-align: left;
	}
</style>
<h1>Relatório de Compras</h1>

<fieldset>
	<!-- FILTROS -->
	<?php		
		if (isset($filters['client_name']) && !empty($filters['client_name'])) {
			echo "Filtrado pelo cliente: ".$filters['client_name']."<br>";
		}
		if (!empty($filters['period1']) && !empty($filters['period2'])) {
			echo "Filtrado no período: ".date('d/m/Y', strtotime($filters['period1']))." a ".date('d/m/Y', strtotime($filters['period2']))."<br>";
		}
		if ($filters['status'] != '') {
			echo "Filtrado com status: ".$statuses[$filters['status']]."<br>";
		}
	?>
</fieldset>
<br>
<table border="0" width="100%">
	<tr>
		<th>Nome do Cliente</th>
		<th>Data</th>
		<th>Valor</th>
		<th>Status</th>		
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
			
		</tr>
	<?php endforeach; ?>
</table>
