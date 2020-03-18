<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="UTF-8">
	<title>Painel - <?php echo $viewData['company_name']; ?></title>
	<!-- LINK TEMPLATE.CSS -->
	<link rel="stylesheet" href="<?php echo BASE_URL ;?>assets/css/template.css">
	<!-- JQUERY -->
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/jquery-3.4.1.min.js"></script>
	<!-- VARIÁVEL JAVASCRIPT -->
	<script type="text/javascript">var BASE_URL="<?php echo BASE_URL;?>";</script> 
	<!-- JAVASCRIPT -->
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/script.js"></script>
</head>
<body>
	<!-- DIV LEFTMENU -->
	<div class="leftmenu">
		<!-- DIV COMPANY_NAME -->
		<div class="company_name">
			<?php echo $viewData['company_name']; ?>
		</div>
		<!-- FIM DIV COMPANY_NAME -->
		<!-- DIV MENUAREA -->
		<div class="menuarea">
			<ul>
				<li><a href="<?php echo BASE_URL ?>">Home</a></li>
				<li><a href="<?php echo BASE_URL ?>permissions">Permissões</a></li>
				<li><a href="<?php echo BASE_URL ?>users">Usuários</a></li>
				<li><a href="<?php echo BASE_URL ?>clients">Clientes</a></li>
				<li><a href="<?php echo BASE_URL ?>inventory">Estoque</a></li>
				<li><a href="<?php echo BASE_URL ?>sales">Vendas</a></li>
			</ul>
		</div>
		<!-- FIM DIV MENUAREA -->
	</div>
	<!-- FIM DIV LEFTMENU -->

	<!-- DIV CONTAINER -->
	<div class="container">
		<!-- DIV TOP -->
		<div class="top">
			<!-- DIV TOP RIGHT -->
			<div class="top_right">
				<a href="<?php echo BASE_URL.'login/logout'; ?>">
					Sair
				</a>
			</div>
			<div class="top_right"><?php echo $viewData['user_email']; ?></div>
			<!-- FIM DIV TOP RIGHT -->
		</div>
		<!-- FIM DIV TOP -->

		<!-- DIV AREA -->
		<div class="area">	
			<?php $this->loadViewInTemplate($viewName, $viewData); ?>
		</div>
		<!-- FIM DIV AREA -->	

	</div>
	<!-- FIM DIV CONTAINER -->

</body>
</html>