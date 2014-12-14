<?php
	/**
	 * File : pages/pages/index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * permet de lancer le bon script en fonction de la page appellé
	 **/

	// Charge le controller
	require '../../includes/includes.php';
	require ROOT_PAGES.'pages/PagesController.php';

	$PagesController = new PagesController();

	// Si la fonction n'a pas été défini on redirige sur la fonction index()
	if(!isset($_GET['function']) && empty($_GET['function']))
	{
		$function = null;
		$PagesController->index();
	}
	else
	{
		$function = $_GET['function'];

		// Suivant la fonction appellé on execute la fonction
		switch($function)
		{
			case 'index' :
				$PagesController->index();
			break;
			
			case 'view':
				$PagesController->view($_GET['id']);	
			break;

			case 'admin_create' :
				$PagesController->admin_create($_GET['token']);
			break;

			case 'admin_index' :
				$PagesController->admin_index();
			break;

			case "admin_edit" :
				$PagesController->admin_edit($_GET['id'], $_GET['token']);
			break;

			case 'admin_delete' :
				$PagesController->admin_delete($_GET['id'], $_GET['token']);
			break;

			// Par défaut on redirige sur la fonction index
			default :
				session_setFlash("La page que vous demandé n'est pas disponible.", "alertError");
				$PagesController->index();
			break;
		}
	}

?>