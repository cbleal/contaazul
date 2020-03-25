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
			<div class="db-info-title">Relatório de Despesas e Receitas dos últimos 30 dias</div>
			<div class="db-info-body" style="height: 360px;">
				<canvas id="rel1"></canvas>
			</div>

		</div>
	</div>
	<div class="grid-1">
		<div class="db-info">
			<div class="db-info-title">Status de Pagamento</div>
			<div class="db-info-body" style="height: 360px;">
				<canvas id="rel2" height="300px"></canvas>
		 	</div>
		</div>
	</div>	
</div>
<!-- FIM DIV DB-ROW 2 -->

<!-- GERAR VARIAVEL -->
<script type="text/javascript">
	var days_list = <?php echo json_encode($days_list); ?>; // transforma array em json
	var revenue_list = <?php echo json_encode(array_values($revenue_list)); ?>;
	var expenses_list = <?php echo json_encode(array_values($expenses_list)); ?>;
	var status_name_list = <?php echo json_encode(array_values($statuses)); ?>;
	var status_list = <?php echo json_encode(array_values($status_list)); ?>;
</script>
<!-- JAVASCRIPT CHART -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/Chart.min.js"></script>
<!-- JAVASCRIPT  -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_home.js"></script>