<!-- <h1>HOME</h1> -->

<!-- DIV DB-ROW 1 -->
<div class="db-row row1">
	<div class="grid-1">
		<div class="db-grid-area">
			<div class="db-grid-area-count"><?php echo $products_sold; ?></div>
			<div class="db-grid-area-legend">Produtos Vendidos</div>
		</div>
	</div>
	<div class="grid-1">
		<div class="db-grid-area">			
			<div class="db-grid-area-count"><?php echo "R$ " . number_format($revenue, 2, ',', '.'); ?></div>
			<div class="db-grid-area-legend">Vendas</div>
		</div>
	</div>
	<div class="grid-1">
		<div class="db-grid-area">
			<div class="db-grid-area-count"><?php echo "R$ " . number_format($expenses, 2, ',', '.'); ?></div>
			<div class="db-grid-area-legend">Compras</div>
		</div>
	</div>	
</div>
<!-- FIM DIV DB-ROW 1 -->

<!-- DIV DB-ROW 2 -->
<div class="db-row row2">
	<div class="grid-2">
		<div class="db-info">
			<div class="db-info-title">Título</div>
			<div class="db-info-body">...</div>
		</div>
	</div>
	<div class="grid-1">
		<div class="db-info">
			<div class="db-info-title">Título</div>
			<div class="db-info-body">...</div>
		</div>
	</div>	
</div>
<!-- FIM DIV DB-ROW 2 -->