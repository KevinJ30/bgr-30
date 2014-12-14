<?php
	/**
	 * File : pages/pages/PagesController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des pages
	 **/

	class PagesController extends Controller
	{
		/**
		 * Index
		 *
		 * Permet d'afficher la page d'accueil du site
		 **/
		public function index()
		{
			// On récupere la page d'accueil dans la base de données
			$accueil = $this->PagesModel->getAccueil();

			// Chargement de la vue
			include ROOT_PAGES.'pages/View/index.php';
		}

		/**
		 * View
		 *
		 * Permet d'afficher un article de la base de données en spécifiant sont id
		 *
		 * @param : id contient l'id de l'article
		 **/
		public function view($id)
		{
			$page = $this->PagesModel->getPage($id);


			// Chargement de la vue
			include ROOT_PAGES.'pages/View/view.php';
		}

		/**
		 * ----------------------- ADMINISTRATION ---------------
		 **/

		/**
		 * admin_create();
		 *
		 * Permet d'ajouter une pages sur le site
		 *
		 * @param : $token jeton csrf()
		 **/
		public function admin_create($token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					header('Location: '.URL_PAGES.'users/index.php?function=login' );
					session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.');
					die();
				}
			}
			else
			{
				header('Location: '.URL_PAGES.'users/index.php?function=login' );
				session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
				die();
			}

			// On test le token
			if(!isset($token) || empty($token))
			{
				// On supprime le token
				session_deleteKey('token');

				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();
			}
			else
			{
				if($_SESSION['token'] != $token)
				{
					// On supprime le token
					session_deleteKey('token');

					$message = "Acc�s refus�.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			// On récupere les menu qui existe sur le site
			$menus = $this->PagesModel->getMenu();

			// Validation des données
			$validator = new Validator(array(
				'title'=>array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'alphaNumeric' =>array(
						'rule' => 'alphaNumeric',
						'message' => 'Le titre ne doit contenir que des caractères alphanumériques.'
					)
				),
				'content' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'La page ne doit pas être vide.'
					)
				)
			), $this->PagesModel, 'pages', false);

			// Si des données sont poster
			if(!empty($_POST))
			{
				// Validator
				if($validator->validates())
				{

					// On test si les case on été cocher
					if(!isset($_POST['status']))
					{
						$_POST['status'] = null;
					}

					if(!isset($_POST['accueil']))
					{
						$_POST['accueil'] = null;
					}

					// Si il n'y a pas d'erreur dans le formulaire on sauvegarde la page dans la base de données
					$this->PagesModel->create($_POST);

					// Une fois la sauvegarde en base effectué,
					// on supprime le token dans la session,
					// et on redirige sur la page admin_index
					header('Location: '.URL_PAGES.'pages/index.php?function=admin_index');
					session_deleteKey('token');
					die();
				}
			}

			// On charge la vue
			include ROOT_PAGES.'pages/View/admin_create.php';
		}

		/**
		 * admin_create();
		 *
		 * Permet d'ajouter une pages sur le site
		 *
		 * @param : $token jeton csrf()
		 **/
		public function admin_edit($id, $token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					header('Location: '.URL_PAGES.'users/index.php?function=login' );
					session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.');
					die();
				}
			}
			else
			{
				header('Location: '.URL_PAGES.'users/index.php?function=login' );
				session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
				die();
			}

			// On test le token
			if(!isset($token) || empty($token))
			{
				// On supprime le token
				session_deleteKey('token');

				$message = "Accés refusé.";
				include ROOT.'errors/error403.php';
				die();
			}
			else
			{
				if($_SESSION['token'] != $token)
				{
					// On supprime le token
					session_deleteKey('token');

					$message = "Accés refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			if(!isset($id) && empty($id))
			{
				// On supprime le token
				session_deleteKey('token');

				$message = "Accés refusé.";
				include ROOT.'errors/error403.php';
				die();
			}

			$page = $this->PagesModel->getPage($id);

			// On récupere les menu qui existe sur le site
			$menus = $this->PagesModel->getMenu();

			if(empty($page))
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'pages/index.php?function=admin_index');
				session_setFlash("La page n'existe pas.", 'alertError');
				die();
			}

			// Validation des données
			$validator = new Validator(array(
				'title'=>array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'alphaNumeric' =>array(
						'rule' => 'alphaNumeric',
						'message' => 'Le titre ne doit contenir que des caractères alphanumériques.'
					)
				),
				'content' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'La page ne doit pas être vide.'
					)
				)
			), $this->PagesModel, 'pages', false);

			// Si des données sont poster
			if(!empty($_POST))
			{
				// Validator
				if($validator->validates())
				{

					// On test si les case on été cocher
					if(!isset($_POST['status']))
					{
						$_POST['status'] = null;
					}

					if(!isset($_POST['accueil']))
					{
						$_POST['accueil'] = null;
					}

					// Si il n'y a pas d'erreur dans le formulaire on sauvegarde la page dans la base de données
					$this->PagesModel->edit($_POST, $id);

					// Une fois la sauvegarde en base effectué,
					// on supprime le token dans la session,
					// et on redirige sur la page admin_index
					header('Location: '.URL_PAGES.'pages/index.php?function=admin_index');
					session_deleteKey('token');
					die();
				}
			}

			// On charge la vue
			include ROOT_PAGES.'pages/View/admin_edit.php';
		}

		/**
		 * admin_elete();
		 *
		 * Permet de supprimer un article
		 *
		 * @param $id : contient l'id de l'article
		 * @param $token
		 **/
		public function admin_delete($id, $token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					header('Location: '.URL_PAGES.'users/index.php?function=login' );
					session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
					die();
				}
			}
			else
			{
				header('Location: '.URL_PAGES.'users/index.php?function=login' );
				session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
				die();
			}

			// On test le token
			if(!isset($token) || empty($token))
			{
				// On supprime le token
				session_deleteKey('token');

				$message = "Accés refusé.";
				include ROOT.'errors/error403.php';
				die();
			}
			else
			{
				if($_SESSION['token'] != $token)
				{
					// On supprime le token
					session_deleteKey('token');

					$message = "Accés refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			if(!isset($id) && empty($id))
			{
				// On supprime le token
				session_deleteKey('token');

				$message = "Accés refusé.";
				include ROOT.'errors/error403.php';
				die();
			}

			// suppression de l'article dans la base de données
			$this->PagesModel->delete($id);

			session_deleteKey('token');

			// redirige sur la page index
			header('Location: '. URL_PAGES.'pages/index.php?function=admin_index');
			die();
		}

		/**
		 * admin_index();
		 *
		 * Affiche la liste des pages du site
		 *
		 **/
		public function admin_index()
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					header('Location: '.URL_PAGES.'users/index.php?function=login' );
					session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
					die();
				}
			}
			else
			{
				header('Location: '.URL_PAGES.'users/index.php?function=login' );
				session_setFlash('Vous devez être connecté, et avoir un compte administrateur pour accéder à cette page.', 'alertError');
				die();
			}

			$pages = $this->PagesModel->getPagesJoinMenu();

			// On charge la vue
			include ROOT_PAGES.'pages/View/admin_index.php';
		}
		/**
		 * -------------------------- 	END -----------------------------
		 **/
	}
?>