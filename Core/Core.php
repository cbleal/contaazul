<?php

# URL: http://localhost/mvc_ps4/cadastro/update/4
# cadastro = controller
# update = action
# 4 = params

namespace Core;

class Core
{
	public function run()
	{
		$url = '/';
		if (isset($_GET['url'])) {
			$url .= $_GET['url']; # /cadastro/update/4
		}

		$params = array();

		if (!empty($url) && $url != '/') {
			// CONTROLLER
			$url = explode('/', $url); # /cadastro/update/4
			# Array ( [0] => [1] => cadastro [2] => update [3] => 4 )
			array_shift($url);
			# Array ( [0] => cadastro [1] => update [2] => 4 )
			$currentController = $url[0].'Controller';
			# cadastroController
			array_shift($url);
			# Array ( [0] => update [1] => 4 )

			// ACTION
			if (isset($url[0]) && !empty($url[0])) {
				$currentAction = $url[0];
				# update
				array_shift($url);
				# Array ( [0] => 4 )
			}
			else {
				$currentAction = 'index';
			}

			// PARAMS
			if (count($url) > 0) {
				$params = $url;
			}
		}
		else {			
			$currentController = 'HomeController';
			$currentAction = 'index';
		}

		$currentController = ucfirst($currentController);
		# CadastroController
		$prefix = '\Controllers\\';
		# \Controller\

		// echo "controller: ".$currentController;
		// echo "<br>";
		// echo "prefix: ".$prefix.$currentController;
		// exit;

		if (!file_exists('Controllers/'.$currentController.'.php') || !method_exists($prefix.$currentController, $currentAction)) {

			$currentController = 'NotFoundController';
			$currentAction = 'index';
		}

		$newController = $prefix.$currentController;
		// echo "controller: ".$newController;
		// exit;
		$c = new $newController();

		call_user_func_array(array($c, $currentAction), $params);
	}
}