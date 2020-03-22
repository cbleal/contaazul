<h1>Compras - Editar</h1>

<strong>Nome do Fornecedor:</strong><br>
<?php echo $purchases_info['info']['provider_name']; ?><br><br>

<strong>Data da Compra:</strong><br>
<?php echo date('d/m/Y', strtotime($purchases_info['info']['date_purchase'])); ?><br><br>

<strong>Total da Compra:</strong><br>
<?php echo number_format($purchases_info['info']['total_price'], 2, ',', '.'); ?><br><br>

<strong>Status:</strong><br>

<?php if ($permission_edit): ?>
<!-- FORMULARIO DE EDIÇÃO -->
<form method="POST">
	<select name="status">
		<?php foreach($statuses as $statusK => $statusV): ?>
			<option value="<?php echo $statusK; ?>" <?php echo ($statusK == $purchases_info['info']['status'])?'selected="selected"':''; ?>>
				<?php echo $statusV; ?>					
			</option>
		<?php endforeach; ?>
	</select>
	<input type="submit" value="Salvar">
</form>
<?php else: ?>
<!-- MOSTRA STATUS -->
<?php echo $statuses[$purchases_info['info']['status']]; ?><br><br>
<?php endif; ?>

<hr/>

<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th>Qtde</th>
		<th>Preço Unitário</th>
		<th>Preço Total</th>
	</tr>
	<?php foreach($purchases_info['products'] as $product_item): ?>
		<tr>
			<td><?php echo $product_item['name']; ?></td>
			<td><?php echo $product_item['quant']; ?></td>
			<td><?php echo number_format($product_item['purchase_price'], 2, ',','.'); ?></td>
			<td><?php echo number_format($product_item['purchase_price'] * $product_item['quant'], 2, ',','.'); ?></td>				
		</tr>
	<?php endforeach; ?>
</table>