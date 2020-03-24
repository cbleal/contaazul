<style type="text/css">
	th {
		text-align: left;
	}
</style>

<h1>Relatório de Estoque</h1>

<fieldset>
	<!-- FILTROS -->	
</fieldset>
<br>
<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Preço</th>
		<th>Qtde</th>
		<th>Qtde Min.</th>		
		<th>Difereça</th>	
	</tr>
	<?php foreach($inventory_list as $inv_item): ?>
		<tr>
			<td>
				<?php echo $inv_item['name']; ?>					
			</td>	
			<td>
				R$ <?php echo number_format($inv_item['price'], 2, ',', '.'); ?>
			</td>
			<td>
				<?php echo $inv_item['quant']; ?>
			</td>
			<td>
				<?php echo $inv_item['min_quant']; ?>
			</td>
			<td>
				<?php echo $inv_item['dif']; ?>
			</td>			
		</tr>
	<?php endforeach; ?>
</table>
