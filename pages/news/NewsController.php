<?php
	/**
	 * File : pages/news/NewsController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des news
	 **/

	class NewsController extends Controller
	{

		/**
		 * Index
		 * 
		 *  Permet d'afficher la liste des news côté utilisateur
		 **/
		public function index($page = null)
		{
			// Contient la limit de la requête
			$limit = array();
			
			// Définit le nombre de news par page
			$nbNewsPages = 5;
			
			$nbPages = ceil($this->NewsModel->countNews()->count / 5);
			
			if($page)
			{
				$depart = $page * $nbNewsPages;
				$fin = 5;
				
				$limit = array(
					'depart' => $depart,
					'fin' => $fin
				);
			}
			else
			{
				$limit = array(
					'depart' => 0,
					'fin' => $nbNewsPages
				);
			}
			
			$news = $this->NewsModel->getNews($limit);
			
			// Chargement de la vue
			include ROOT_PAGES.'news/view/index.php';
		}
		
		/***********************************************
		 * -------------- ADMINISTRATION --------------*
		 ***********************************************/
		
		/**
		 * admin_add
		 *
		 * Permet d'ajouter une news sur le site
		 *
		 * @param : $token : jeton csrf
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
					'title' => array(
							'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
							),
							'alphaNumeric' =>	array(
									'rule' => 'alphaNumeric',
									'message' => 'Le nom du menu ne doit comporter que des caractères alphanumériques.'
							)
					)
			), $this->NewsModel, 'news', false);
			
			
			if(!empty($_POST))
			{
				if($validator->validates())
				{
					// On test si les case on été coché
					if(!isset($_POST['status']))
					{
						$_POST['status'] = null;
					}
					
					if(!isset($_POST['accueil']))
					{
						$_POST['accueil'] = null;
					}

					$this->NewsModel->insert(array(
						'title' => $_POST['title'],
						'content' => $_POST['content'],
						'status' => $_POST['status'],
						'users_id'  => $_SESSION['auth']['id']	
					));
					
					header('Location: '.URL_PAGES.'news/index.php?function=admin_index', 'alertSuccess');
					session_deleteKey('token');
					die();
				}	
			}
		
			// Chargement de la vue
			include ROOT_PAGES.'news/view/admin_add.php';
		}
		
		/**
		 * admin_edit
		 *
		 * Permet d'ajouter une news sur le site
		 *
		 * @param : $token : jeton csrf
		 * @param : $id : id de la news à editer
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
			
			$news = $this->NewsModel->firstNews($id);
			
			$validator = new Validator(array(
					'title' => array(
							'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
							),
							'alphaNumeric' =>	array(
									'rule' => 'alphaNumeric',
									'message' => 'Le nom du menu ne doit comporter que des caractères alphanumériques.'
							)
					)
			), $this->NewsModel, 'news', false);
			
			if(isset($id) && !empty($id))
			{
				if(!empty($news))
				{
					if(!empty($_POST))
					{
						if($validator->validates())
						{
							$this->NewsModel->update($_POST, $id);
			
							// On redirige vers la list des menus
							session_deleteKey('token');
			
							header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
							session_setFlash("L'actualité à bien été edité.", 'alertSuccess');
							die();
						}
					}
				}
				else
				{
					session_deleteKey('token');
			
					header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
					session_setFlash("L'actualité n'existe pas.", 'alertError');
					die();
				}
			}
			else
			{
				session_deleteKey('token');
					
				header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
				session_setFlash("L'actualité n'existe pas.", 'alertError');
				die();
			}
		
			// Chargement de la vue
			include ROOT_PAGES.'news/view/admin_edit.php';
		}
		
		/**
		 * admin_delete
		 *
		 * Permet d'ajouter une news sur le site
		 *
		 * @param : $token : jeton csrf
		 * @param : $id : id de la news à editer
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
				
			$news = $this->NewsModel->firstNews($id);
			
			if(!isset($id) && empty($id))
			{
				session_deleteKey('token');
					
				header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
				session_setFlash("L'actualité n'existe pas.", 'alertError');
				die();
			}
			else
			{
				if(empty($news))
				{
					session_deleteKey('token');
						
					header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
					session_setFlash("L'actualité n'existe pas.", 'alertError');
					die();
				}
			}
			
			$this->NewsModel->delete($id);
			
			// On redirige vers la list des menus
			session_deleteKey('token');
			
			header('Location: '.URL_PAGES.'news/index.php?function=admin_index');
			session_setFlash("L'actualité à bien été supprimer.", 'alertSuccess');
			die();
			
			
			// Chargement de la vue
			include ROOT_PAGES.'news/view/admin_edit.php';
		}
		
		
		/**
		 * admin_index
		 *
		 * affiche la liste des news dans un tableaux
		 *
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

			$news = $this->NewsModel->getNews();
			
			// Chargement de la vue
			include ROOT_PAGES.'news/view/admin_index.php';
		}
	}