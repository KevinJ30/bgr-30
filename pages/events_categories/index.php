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
	require ROOT_PAGES.'events_categories/Events_CategoriesController.php';

	$Events_CategoriesController = new Events_CategoriesController();
        
	// si la function n'a pas été définit on redirige sur la fonction index
	if(!isset($_GET['function']) && empty($_GET['function']))
	{
		$function = null;
		$Events_CategoriesController->index();
	}
	else
	{
        $function = $_GET['function'];
		switch($function)
		{
            case "index":
            	$Events_CategoriesController->index();
            break;
                
            /**
             * Back Office
             **/
            case "admin_index":
            	$Events_CategoriesController->admin_index();
            break;

            case "admin_add":
            	$Events_CategoriesController->admin_add($_GET['token']);
            break;

            case "admin_edit":
            	$Events_CategoriesController->admin_edit($_GET['id'], $_GET['token']);
            break;

            case "admin_delete":
            	$Events_CategoriesController->admin_delete($_GET['id'], $_GET['token']);
            break;
		}
	}
?>