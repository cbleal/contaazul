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
	<?php $total_quant = 0; ?>
	<?php $total_min_quant = 0; ?>
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
			<?php echo $total_quant += $inv_item['quant']; ?>		
			<?php echo $total_min_quant += $inv_item['min_quant']; ?>		
	<?php endforeach; ?>
	<tr>
		<td></td>
		<td></td>
		<td>---------</td>
		<td>---------</td>
		<td></td>
	</tr>
	<tr>
		<td>Totais:</td>
		<td></td>
		<td>
			<?php echo $total_quant; ?>
		</td>
		<td>
			<?php echo $total_min_quant; ?>
		</td>
	</tr>
</table>
