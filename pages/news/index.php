<?php
	/**
	 * File : pages/news/index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * permet de lancer le bon script en fonction de la page appellé
	 **/

	// Charge le controller
	require '../../includes/includes.php';
	require ROOT_PAGES.'news/NewsController.php';
	
	$function = null;
	
	// Instance du controller news
	$NewsController = new NewsController();

	// Si la variable function n'est pas définit ou  qu'elle est vide on charge l'index du controller
	if(!isset($_GET['function']) && empty($_GET['function']))
	{
		$NewsController->index();
	}
	else
	{
		// Sinon on charge la methode du controller en fonction de la fonction appellé
		
		$function = $_GET['function'];
		
		switch($function)
		{
			// Liste des news
			case 'index':
				$NewsController->index(isset($_GET['page']) ? $_GET['page'] : null);
			break;
			
			// Permet d'ajouter des news
			case 'admin_add':
				$NewsController->admin_add($_GET['token']);	
			break;
			
			// Permet d'afficher la liste des news pour les administrateur
			case 'admin_index':
				$NewsController->admin_index();
			break;
			
			// Permet d'editer une news
			case 'admin_edit':
				$NewsController->admin_edit($_GET['id'], $_GET['token']);
			break;
			
			// Permet de supprimer une news
			case 'admin_delete':
				$NewsController->admin_delete($_GET['id'], $_GET['token']);
				break;
			
			default :
				session_setFlash("La page que vous demandé n'est pas disponible.", "alertError");
				$NewsController->index();	
			break;
		}
	}
	
	