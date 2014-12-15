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
	require ROOT_PAGES.'events/EventsController.php';

	$EventsController = new EventsController();

	// si la function n'a pas été définit on redirige sur la fonction index
	if(!isset($_GET['function']) && empty($_GET['function']))
	{
		$function = null;
		$EventsController->index();
	}
	else
	{
		$function = $_GET['function'];

		switch($function)
		{
            case "index":
            	$EventsController->index();
            break;

            case "admin_index" :
            	$EventsController->admin_index();
            break;

            case "admin_add" :
            	$EventsController->admin_add($_GET['token']);
            break;

            case "admin_edit" :
            	$EventsController->admin_edit($_GET['id'], $_GET['token']);
            break;

            case "admin_delete" :
            	$EventsController->admin_delete($_GET['id'], $_GET['token']);
            break;

            default :
            	header('Location:'.URL_ROOT.'index.php');
            	session_setFlash("La page n'xiste pas.", "alertError");
            	die();
            break;
		}
	}
?>