<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="UTF-8">
	<title>Conta Azul</title>
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/login.css">
</head>
<body>

	<div class="loginarea">
		<form method="POST">
			<input type="email" name="email" placeholder="Digite seu e-mail"/>
			<input type="password" name="password" placeholder="Digite sua senha"/>
			<input type="submit" value="Entrar"/>

			<?php if (isset($error) && !empty($error)): ?>
				<div class="warning"><?php echo $error ?></div>
			<?php endif; ?>	
		</form>
	</div>

</body>
</html>