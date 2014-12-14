<?php
	/**
	 * File : pages/users/UsersController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des menus du site
	 **/

	class MenusController extends Controller
	{

		/**
		 * admin_index()
		 *
		 * Permet d'afficher la liste des menu
		 **/
		public function admin_index()
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();
			}

			$menus = $this->MenusModel->admin_getMenus();

			// Chargement de la vue
			include ROOT_PAGES.'menus/view/admin_index.php';
		}

		/**
		 * admin_add
		 *
		 * Permet d'ajouter un menu sur le site
		 *
		 * @param : $token jeton csrf
		 **/
		public function admin_add($token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
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

					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			$validator = new Validator(array(
				'name' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'alphaNumeric' =>	array(
						'rule' => 'alphaNumeric',
						'message' => 'Le nom du menu ne doit comporter que des caractères alphanumériques.'
					)
				)
			), $this->MenusModel, 'menus', true);

			if(!empty($_POST))
			{
				if($validator->validates())
				{
					$this->MenusModel->admin_add($_POST['name']);

					session_deleteKey('token');

					header('Location: '.URL_PAGES.'menus/index.php');
					session_setFlash('Le menu a bien été ajouté.', 'alertSuccess');
					die();
				}
			}

			// Chargement de la vue
			include ROOT_PAGES.'menus/view/admin_add.php';
		}

		/**
		 * admin_add
		 *
		 * Permet d'ajouter un menu sur le site
		 *
		 * @param : $id id du menu
		 * @param : $token jeton csrf
		 **/
		public function admin_delete($id, $token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
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

					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			$menu = $this->MenusModel->admin_getMenu($id);

			if(isset($id) && !empty($id))
			{
				if(!empty($menu))
				{
					/** -- On recherche les article associer au menu --**/
					include ROOT_PAGES.'pages/PagesModel.php';
					$pagesModel = new PagesModel('pages');

					$pages = $pagesModel->getPagesMenu($id);

					foreach($pages as $page)
					{
						$pagesModel->setMenu_id($page->id, 0);
					}
					/*----------------------- END ------------------*/
					$this->MenusModel->admin_delete($menu->id);

					// On redirige vers la list des menus
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'menus/index.php');
					session_setFlash('Le menu a bien été supprimé.', 'alertSuccess');
					die();
				}
				else
				{
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'menus/index.php');
					session_setFlash("Le menu n'existe pas.", 'alertError');
					die();
				}
			}
			else
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'menus/index.php');
				session_setFlash("Le menu n'existe pas.", 'alertError');
				die();
			}
		}

		/**
		 * admin_edit
		 *
		 * Permet d'editer un menu sur le site
		 *
		 * @param : $id id du menu
		 * @param : $token jeton csrf
		 **/
		public function admin_edit($id, $token)
		{
			// test si il est admin ou autheur
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
				{
					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
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

					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

			$menu = $this->MenusModel->admin_getMenu($id);

			$validator = new Validator(array(
				'name' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'unique' => array(
						'rule' => 'unique',
						'message' => 'Le menu existe déja.'
					)
				)
			), $this->MenusModel, 'menus', true);


			if(isset($id) && !empty($id))
			{
				if(!empty($menu))
				{
					$name = $menu->name;

					if(!empty($_POST))
					{
						if($validator->validates())
						{
							$this->MenusModel->admin_setMenu($id, $_POST['name']);

							// On redirige vers la list des menus
							session_deleteKey('token');

							header('Location: '.URL_PAGES.'menus/index.php');
							session_setFlash('Le menu a bien été edité.', 'alertSuccess');
							die();
						}
					}
				}
				else
				{
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'menus/index.php');
					session_setFlash("Le menu n'existe pas.", 'alertError');
					die();
				}
			}
			else
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'menus/index.php');
				session_setFlash("Le menu n'existe pas.", 'alertError');
				die();
			}

			// Chargement de la vue
			include ROOT_PAGES.'menus/view/admin_edit.php';
		}
	}
?>