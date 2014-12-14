<?php
	/**
	 * File : pages/menus/index.php.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet de gérer le chargement des fonctions du script
	 **/

	// Charge le controller
	require '../../includes/includes.php';
	require ROOT_PAGES.'menus/MenusController.php';

	$MenusController = new MenusController();

	// Redirige sur la list des menus
	if(!isset($_GET['function']) && empty($_GET['function']))
	{
		$function = null;
		$MenusController->admin_index();
	}
	else
	{
		$function = $_GET['function'];

		switch($function)
		{
			// List des menu
			case 'index':
				$MenusController->admin_index();
			break;

			// Ajouter un menu
			case 'admin_add':
				$MenusController->admin_add($_GET['token']);
			break;

			case 'admin_delete':
				$MenusController->admin_delete($_GET['id'], $_GET['token']);
			break;

			case 'admin_edit' :
				$MenusController->admin_edit($_GET['id'], $_GET['token']);
			break;

			default :
				session_setFlash("La page que vous demandé n'est pas disponible.", "alertError");
				$MenusController->admin_index();
			break;
		}
	}
?>