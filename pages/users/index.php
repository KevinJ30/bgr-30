<?php
	/**
	 * File : pages/users/controller/LoginController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet de gérer le chargement de fonction du script
	 **/

	// Charge le controller
	require '../../includes/includes.php';
	require ROOT_PAGES.'users/UsersController.php';

	$UsersController = new UsersController();

	// Si l'url ne contient pas la fonction a charger
	// On execute la fonction par default
	if(!isset($_GET['function']))
	{
		$UsersController->index();
	}
	else
	{
		$function = $_GET['function'];

		switch($function)
		{
				case 'index' :
					$UsersController->index();
				break;

				case 'login':
					$UsersController->login();
				break;

				case 'logout':
					$UsersController->logout($_GET['token']);
				break;

				case 'register':
					$UsersController->register();
				break;

				case 'activate' :
					$UsersController->activate($_GET['token'], $_GET['username']);
				break;

				case 'profil' :
					$UsersController->profil($_GET['id']);
				break;

				case 'confirmPassword':
					$UsersController->confirmPassword($_GET['token'], $_GET['check'], $_GET['id']);
				break;

				// Administration

				case 'admin_add' :
					$UsersController->admin_add($_GET['token'], $_SESSION['auth']['permission']);
				break;

				case 'admin_list' :
					$UsersController->admin_list();
				break;

				case 'admin_delete' :
					$UsersController->admin_delete($_GET['id'], $_GET['token']);
				break;

				case 'admin_edit' :
					$UsersController->admin_edit($_GET['id'], $_GET['token']);
				break;

				case 'admin_changeStatus' :
					$UsersController->admin_changeStatus($_GET['id'], $_GET['token']);
				break;

				case 'admin_changePermission' :
					$UsersController->admin_changePermission($_GET['id'], $_GET['token']);
				break;

				// Si la fonction n'est pas trouvé on redirige sur une erreur 404 Not Found
				default:
					session_setFlash("La page que vous demandé n'est pas disponible.", "alertError");
					header('Location: '.URL_ROOT.'index.php');
				break;

		}
	}
?>