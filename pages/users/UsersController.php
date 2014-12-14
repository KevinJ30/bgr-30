<?php
	/**
	 * File : pages/users/UsersController.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet la gestion des comptes utilisateur du site
	 **/

	class UsersController extends Controller
	{
		// redirige sur la page de connection
		public function index(){/* Aucune action possible avec cette fonction */}

		// Si le password correspond à l'utilisateur on le connect
								

		/**
		 * Login
		 *
		 * Permet de se connecter sur le site
		 **/
		public function login()
		{
			$validator = new Validator(array(
				'username' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					)
				),
				'password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					)
				)
			), $this->UsersModel, true);


			// Si la personne est déja connecté on la redirige sur la page d'accueil
			if(isset($_SESSION['auth']))
			{
				header('Location: '.URL_ROOT.'/index.php');
				session_setFlash('Vous êtes déja connecté sur le site.', 'alertError');
				die();
			}

			// Si des données sont poster
			if(!empty($_POST))
			{
				// Si aucune erreur est générer
				if($validator->validates())
				{
					$user = $this->UsersModel->getUser(array('username' => $_POST['username']));
					
					// Si on a trouvé un utilisateur
					if(!empty($user))
					{
						// on test le password qu'il à noté
						if($user->password == sha1($_POST['password']))
						{
							if($user->active == 1 && $user->banned == 0)
							{
								$_SESSION['auth'] = array(
									'id' => $user->id,
									'username' => $user->username,
									'password' => $user->password,
									'nom' => $user->nom,
									'prenom' => $user->prenom,
									'mail' => $user->mail,
									'created' => $user->created,
									'permission' => $user->permission,
									'avatar' => $user->avatar,
									'type_token' => $user->type_token,
									'token' => $user->token
								);

								// On redirige la personne sur la page d'accueil du site
								header('Location: '.URL_ROOT.'/index.php');
								session_setFlash('Vous êtes connecté.', 'alertSuccess');
								die();	
							}
							else
							{
								// On redirige la personne sur la page d'accueil du site
								header('Location: '.URL_ROOT.'/index.php');
								session_setFlash("Vous n'avez pas activé votre compte.", 'alertError');
								die();	
							}
							
						}
						else
						{
							$validator->errorMessage['password']['message'] = "Votre mot de passe est incorrect.";
						}
					}
					else
					{
						$validator->errorMessage['username']['message'] = "Votre identifiant est incorrect.";
					}
				}
			}
			// Chargement de la vue
			include ROOT_PAGES.'users/view/login.php';
		}

		/**
		 * ----------------------- END -------------
		 **/

		/**
		 * logout
		 *
		 * ¨Permet de se deconnecté du site
		 *
		 * @param $id : L'id de l'utilisateur a déconnecter
		 * @param : $token : contient le jeton csrf
		 **/
		public function logout($token)
		{
			// Si le token exsite pas on redirige sur une erreur 403 Forbidden
			if(empty($token))
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();
			}

			// Si la personne n'est pas connecté on redirige directement sur la page d'accueil
			if(!isset($_SESSION['auth']))
			{
				header('Location: '.URL_ROOT.'/index.php');
				die();
			}
			else // Sinon on on test le token pour savoir si il a bien fait la demande pour se déconnecter
			{
				if($_SESSION['token'] == $_GET['token'])
				{
					// On détrui la session auth et le token
					session_deleteKey('auth');
					session_deleteKey('token');
					header('Location: '.URL_ROOT.'/index.php');
					session_setFlash('Vous avez été déconnecté.', "alertSuccess");
					die();
				}
				else // Si il n'a pas fait la demande, on redirige sur une erreur 403 Forbidden
				{
					$message = "Accès refusé.";
					include ROOT.'errors/error403.php';
					die();
				}
			}

		}
		/**
		 * --------------------- END -----------------
		 **/

		/**
		 * Register
		 *
		 * Permet de s'inscrire sur le site
		 **/
		public function register()
		{

			/** 
			 * Validation des données 
			 **/
			$validator = new Validator(array(
				'username' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'vous devez renseigner ce champ.'
					),
					'alphanumeric' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Votre identifiant doit être au format alphanumérique.'
					),
					'minlength' => array(
						'rule' => array('minLength', 2),
						'message' => 'Votre identifiant doit comporter au minimum 2 caractères.'
					),
					'unique' => array(
						'rule' => 'unique',
						'message' => "L'identifiant est déjà utilisé." 
					)
				),
				'password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'upper' => array(
						'rule' => 'upper',
						'message' => 'Votre mot de passe doit contenir au moin une majuscule.'
					),
					'minlength' => array(
						'rule' => array('minLength', 8),
						'message' => 'Votre mot de passe doit contenir au moin 8 caractères.'
					)
				),
				'check_password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'egalTo' => array(
						'rule' => array('egalTo', 'password'),
						'message' => 'Votre mot de passe ne correspond pas avec le mot de passe de confirmation.'
					)
				),
				'mail' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'mail' => array(
						'rule' => 'mail',
						'message' => "Votre adresse e-mail n'est pas valide."
					)
				),
				'nom' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'alphaNumeric' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Votre nom doit être au format alphanumérique.'
					),
					'minlegth' => array(
						'rule' => array('minLength', 2),
						'message' => 'Votre nom doit contenir au moin de 2 caractères.'
					)
				),
				'prenom' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'alphaNumeric' => array(
						'rule' => 'alphaNumeric',
						'message' => 'Votre nom doit être au format alphanumérique.'
					),
					'minlegth' => array(
						'rule' => array('minLength', 2),
						'message' => 'Votre nom doit contenir au moin de 2 caractères.'
					)
				),
				'licence' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					),
					'numeric' => array(
						'rule' => 'numeric',
						'message' => 'Votre numéro de licence ne doit contenir que des chiffres.'
					)
				)
			), $this->UsersModel, 'users', true);

			/**
			 * -------------- END validation ----------------
			 **/

			// Si des données on été posté
			if(!empty($_POST))
			{
				// Si il y a aucune erreur dans le formulaire,
				// on enregistre le compte dans la base de données
				// et on envoie un mail pour la confirmation de l'inscription
				if($validator->validates())
				{
					echo 1111;
					// test du numéro de licence
					if($this->UsersModel->check_licence($_POST['licence'], $_POST['nom'], $_POST['prenom']))
					{

					$token = session_generateToken();
					$this->UsersModel->register(array(
						'username' => $_POST['username'],
						'password' => sha1($_POST['password']),
						'nom' => $_POST['nom'],
						'prenom' => $_POST['prenom'],
						'mail' => $_POST['mail'],
						'licence' => $_POST['licence'],
						'permission' => 'membre',
						'active' => 0,
						'banned' => 0,
						'type_token' => 'active',
						'token' => $token
					));

					// Envoie du mail de confirmation
					$subject = 'Confirmation de votre inscription sur le site.';
					$destinataire = $_POST['mail'];

					$link = 'http://'.$_SERVER['SERVER_NAME'].URL_PAGES.'users/index.php?function=activate&token='.$token .'&username='.$_POST['username']. "\r\n";

					$headers  = 'MINE-Version: 1.0' . "\r\n";
					$headers .= 'From: BGR-30<bgr30@bgr.com>' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";

					$message = '
						<html>
							<head>
								<title>Confirmation de votre inscription</title>
								<link rel="stylesheet" href="'.URL_TEMPLATE.'/css/BGR/design.css">
								<link rel="stylesheet" href="'.URL_TEMPLATE.'/css/BGR/design.css">
							</head>
							<body>
								<p>Bonjour, '.$_POST['username'].' le badminton Gard rhodanien vous souhaite la bienvenue.</p>
								<p>Pour confirmer votre inscription sur le site veuillez cliquer ou copier/coller le lien ci-dessous :<p>
								<a href="'.$link.'">'.$link.'</a></p>
								<p><small>Ceci est un mail automatique, veuillez à ne pas y répondre, merci d’avance.</small></p>
							</body>
							<html>
					';
					
					// Envoie du mail

					if(mail($destinataire, $subject, $message, $headers))
					{
						echo "Mail envoyé.";
					}
					else
					{
						echo "Une erreur c'est produite.";
					}

					header('Location: '.URL_ROOT.'/index.php');
					session_setFlash("Votre inscription a bien été prise en compte.<br />Un mail de confirmation vous a été envoyé.", 'alertSuccess');
					die();
					}
					else
					{
						$validator->errorMessage['licence']['message'] = "Votre numéro de licence est incorrect.";
					}
				}

			}

			// Chargement de la vue
			include ROOT_PAGES.'users/view/register.php';
		}

		/**
		 * Activate
		 *
		 * Permet l'activation du compte
		 * @param : $token : jeton csrf
		 * @param : $username contient l'identifiant de la personne
 		 **/
		public function activate($token, $username)
		{
			if(isset($token) && !empty($token))
			{
				$token = htmlentities($token);

				if(isset($username) && !empty($username))
				{
					$username = htmlentities($username);

					if($this->UsersModel->activate($username, $token))
					{
						// Si tous c'est bien passer on redirige sur la page d'accueil
						header('Location: '.URL_ROOT.'/index.php');
						session_setFlash('Votre compte a été activé.', 'alertSuccess');
						die();
					}
					else
					{
						$message = "Votre lien de confirmation n'est pas valide.";
						include ROOT.'errors/error404.php';
						die();
					}

				}
				else
				{
					$message = "Votre lien de confirmation n'est pas valide.";
					include ROOT.'errors/error404.php';
					die();
				}
			}	
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();
			}
		}
		/**
		 * ---------------- END ------------
		 **/

		/**
		 * Profil
		 *
		 * Permet d'afficher le profil
		 * @param $id: id de l'utilisateur
		 **/
		public function profil($id)
		{
			// Si l'id n'est pas renseigner retourne une erreur 403 Forbidden
			if(isset($id) && !empty($id))
			{
				$user = $this->UsersModel->getProfil($id);

				// Si le compte n'existe pas retourne une erreur 403 Forbidden
				if(!empty($user))
				{
					if(isset($_SESSION['auth']) && $user->id == $_SESSION['auth']['id'])
					{
						// Régle de validation
						$validator = new Validator(array(
							'username' => array(
								'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
								),
								'alphanumeric' => array(
									'rule' => 'alphaNumeric',
									'message' => 'Votre identifiant doit êtres au format alphanumérique.'
								),
								'minLength' => array(
									'rule' => array('minLength', 4),
									'message' => 'Votre identifiant doit contenir au minimum 4 caractères.'
								),
								'unique' => array(
									'rule' => 'unique',
									'message' => "L'identifiant est déjà utilisé."
								)
							),
							'mail' => array(
								'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
								),
								'mail' => array(
									'rule' => 'mail',
									'message' => "Votre adresse n'est pas valide."
								)
							),
							'actuPassword' => array(
								'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
								)
							),
							'password' => array(
								'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
								),
								'minLength' => array(
									'rule' => array('minLength', 8),
									'message' => 'Votre mot de passe doit contenir 8 caractères minimum.'
								),
								'upper' => array(
									'rule' => 'upper',
									'message' => 'Votre mot de passe doit contenir au moin une majuscule.'
								)
							),
							'check-password' => array(
								'notEmpty' => array(
									'rule' => 'notEmpty',
									'message' => 'Vous devez renseigner ce champ.'
								),
								'egalTo' => array(
									'rule' => array('egalTo', 'password'),
									'message' => 'Votre mot de passe ne correspond pas avec le mot de passe de confirmation.'
								)
							)
						), $this->UsersModel, 'users', true);

						if(isset($_POST) && !empty($_POST))
						{
							// Si on change son identifiant 

							if(isset($_POST['username']))
							{
								// Si on demande a changer l'identifiant
								if($user->username != $_POST['username'])
								{
									if($validator->validates())
									{
										$this->UsersModel->updateUsername($_POST['username'], $id);
										header('Location: '.URL_PAGES.'users/index.php?function=profil&id='.$user->id);
										session_setFlash("L'identifiant a été modifier.", 'alertSuccess');
										die();
									}
								}
							}

							// Si on change son adresse mail
							if(isset($_POST['mail']))
							{
								if($user->mail != $_POST['mail'])
								{
									if($validator->validates())
									{
										$this->UsersModel->updateMail($_POST['mail'], $id);
										header('Location: '.URL_PAGES.'users/index.php?function=profil&id='.$user->id);
										session_setFlash("Votre adresse e-mail a été modifier.", 'alertSuccess');
										die();
									}
								}
							}

							// Si on change son mot de passe
							if(isset($_POST['actuPassword']) && isset($_POST['password']) && isset($_POST['check-password']))
							{
								// On test le password actuel
								if($user->password == sha1($_POST['actuPassword']))
								{
									// Envoie d'un mail de confirmation
									$token = session_generateToken();
									$subject = 'Confirmation du changement du mot de passe';
									$destinataire = $user->mail;
									echo $user->mail;
									
									$link = 'http://'.$_SERVER['SERVER_NAME'].URL_PAGES.'users/index.php?function=confirmPassword&token='.$token .'&check=true&id='.$user->id. "\r\n";
									$linkError = 'http://'.$_SERVER['SERVER_NAME'].URL_PAGES.'users/index.php?function=confirmPassword&token='.$token .'&check=false&id='.$user->id. "\r\n";

									

									$headers  = 'MINE-Version: 1.0' . "\r\n";
									$headers .= 'From: BGR-30<bgr30@bgr.com>' . "\r\n";
									$headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";

									$message = '
												<html>
													<head>
														<title>Confirmation de votre inscription</title>
														<link rel="stylesheet" href="'.URL_TEMPLATE.'/css/BGR/design.css">
														<link rel="stylesheet" href="'.URL_TEMPLATE.'/css/BGR/design.css">
													</head>
													<body>
														<p>Bonjour, '.$user->username.' votre demande changement de mot de passe a été prise en compte.</p>
														<p>Pour confirmer votre changement de mot de passe veuillez cliquer ou copier/coller le lien ci-dessous :</p>
														<p><a href="'.$link.'">'.$link.'</a></p>
														<p><strong>Attention tant que vous n\'aurait pas confirmer le changement de votre mot de passe, le compte restera inactif.</strong></p>
														<p><strong>Si vous n\'avez pas fait de demande pour changer votre mot de passe, veuillez cliquer ou copier/coller le lien ci-dessous:</strong></p>
														<p><a href="'.$linkError.'">'.$linkError.'</a></p>
														<p><small>Ceci est un mail automatique, veuillez à ne pas y répondre, merci d’avance.</small></p>
													</body>
													<html>
												';

									// Envoie du mail
									mail($destinataire, $subject, $message, $headers);
									
									// On sauvegarde les données dans la base de données
									$this->UsersModel->updatePassword(array(
										'id' => $id,
										'password' => sha1($_POST['password']),
										'active' => 0,
										'type_token' => 'change',
										'token' => $token
									));

									header('Location: '.URL_PAGES.'users/index.php?function=profil&id='.$user->id);
									session_setFlash("Votre mot de passe a été modifier.<br />Un mail de confirmation vous a été envoyé.", 'alertSuccess');
									die();
								}
								else
								{
									$validator->errorMessage['actuPassword']['chaine'] = $_POST['actuPassword'];
									$validator->errorMessage['actuPassword']['message'] = 'Votre mot de passe est incorrect.';
								}
							}
						}
					}
					else
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
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();	
			}

			// Chargement du de la vue
			include ROOT_PAGES.'users/view/profil.php';
		}
		
		/**
		 * confirPassword
		 *
		 * @param : $token : jeton csfrf
		 * @param : $check annule la demande
		 * @param : $id id du compte
		 **/
		public function confirmPassword($token, $check, $id)
		{	
			if(isset($id) && !empty($id))
			{
				if(isset($token) && !empty($token))
				{
					$user = $this->UsersModel->getProfil($id);

					$password = $user->password;
					$tmp_password = $user->tmp_password;

					if($user->token == $token && $user->type_token == 'change')
					{
						if($check == 'true')
						{
							$this->UsersModel->confirmPassword($tmp_password, $check, $id);

							header('Location: '.URL_ROOT.'/index.php');
							session_setFlash("Votre mot de passe a bien été changé.", 'alertSuccess');
							die();
						}
						else
						{
							$this->UsersModel->confirmPassword($password, $check, $id);

							header('Location: '.URL_ROOT.'/index.php');
							session_setFlash("La demande de changment de mot de passe a bien été annulé.", 'alertSuccess');
							die();
						}

					}
					else
					{
						$message = "Votre lien de confirmation n'est pas valable.";
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
			}
			else
			{
				$message = "Accès refusé.";
				include ROOT.'errors/error403.php';
				die();	
			}
		}

		/**
		 * ----------------------------- 
		 * 		ADMINISTRATION
		 * ----------------------------- 
		 **/

		/**
		 * admin_add
		 *
		 * Permet de crées un nouveau compte
		 * @param $token :contient un jeton csrf
		 **/
		public function admin_add($token)
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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


			// Validation des données
			$validator = new Validator(array(
				'username' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champs.'
					),
					'unique' => array(
						'rule' => 'unique',
						'message' => "L'identifiant est déjà utilisé."
					)
				),

				'password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					)
				),
				'nom' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					)
				),
				'prenom' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Vous devez renseigner ce champ.'
					)
				)
			), $this->UsersModel, 'users', true);


			if(isset($_POST) && !empty($_POST))
			{
				// Si active n'existe pas dans le formulaire on le crées et le met a 0
				!isset($_POST['active']) ? $_POST['active'] = 0 : null;
				//--------------------------------------------------------------------

				$_POST['password'] = sha1($_POST['password']);

				if($validator->validates())
				{
					session_deleteKey('token');

					$this->UsersModel->add($_POST);
					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash('Le compte a bien été crée.', 'alertSuccess');
					die();
				}
			}

			// Chargement du de la vue
			include ROOT_PAGES.'users/view/admin_add.php';
		}

		/**
		 * admin_list
		 *
		 * Permet d'afficher la list des compte sur le site
		 **/
		public function admin_list()
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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

			$comptes = $this->UsersModel->getComptes();

			// Chargement du de la vue
			include ROOT_PAGES.'users/view/admin_list.php';	
		}

		/**
		 * admin_delete
		 *
		 * Permet de supprimer un compte
		 * 
		 * @param $id id du compte à supprimer
		 * @param $token jeton csrf
		 **/
		public function admin_delete($id, $token)
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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

			if(!isset($id) || empty($id))
			{
				header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
				session_setFlash("Le compte n'existe pas.", 'alertError');
				die();
			}
			else
			{
				$profil = $this->UsersModel->getProfil($id);

				if(!empty($profil))
				{
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


					$this->UsersModel->deleteCompte($id);

					if($_SESSION['auth']['id'] == $id)
					{
						unset($_SESSION['auth']);
					}

					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash('Le compte a bien été supprimer.', 'alertSuccess');
					die();
				}
				else
				{
					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash("Le compte n'existe pas.", 'alertError');
					die();	
				}
			}
		}

		/**
		 * admin_edit
		 * Permet a l'admin d'éditer un compte
		 *
		 * @param : $id id du compte
		 * @param : $token jeton csrf
		 **/

		public function admin_edit($id, $token)
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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

			if(isset($id) && !empty($id))
			{
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

				$profil = $this->UsersModel->getProfil($id);


				if(empty($profil))
				{
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash("Le compte n'existe pas.", 'alertError');
					die();	
				}

				$validator = new Validator(array(
					'username' => array(
						'notEmpty' => array(
							'rule' => 'notEmpty',
							'message' => 'Vous devez renseigner ce champs.'
						),
						'unique' => array(
							'rule' => 'unique',
							'message' => "L'identifiant est déjà utilisé."
						)
					),
					'nom' => array(
						'notEmpty' => array(
							'rule' => 'notEmpty',
							'message' => 'Vous devez renseigner ce champ.'
						)
					),
					'prenom' => array(
						'notEmpty' => array(
							'rule' => 'notEmpty',
							'message' => 'Vous devez renseigner ce champ.'
						)
					)
				), $this->UsersModel, 'users', true);

				$username = $profil->username;
				$nom = $profil->nom;
				$prenom = $profil->prenom;
				$username = $profil->username;
				$active = $profil->active;
				$permission = $profil->permission;

				if(!empty($_POST))
				{
					if($validator->validates())
					{
						// Si active n'existe pas dans le formulaire on le crées et le met a 0
						!isset($_POST['active']) ? $_POST['active'] = 0 : null;
						//--------------------------------------------------------------------

						// Si le password n'a pas changé on rentre le même
						if(empty($_POST['password']))
						{
							$_POST['password'] = $profil->password;
						}

						// On rentre l'id du compte
						$_POST['id'] = $id;

						// On sauvegarde les données
						$this->UsersModel->admin_edit($_POST);

						session_deleteKey('token');

						header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
						session_setFlash("Le compte a été modifier.", 'alertSuccess');
						die();	
					}
				}
			}
			else
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
				session_setFlash("Le compte n'existe pas.", 'alertError');
				die();	
			}

			// Chargement du de la vue
			include ROOT_PAGES.'users/view/admin_edit.php';	
		}

		/**
		 * admin_changeStatus
		 *
		 * Permet de changer le status du compte
		 *
		 * @param id id du compte
		 * @param token jeton csrf
		 **/

		public function admin_changeStatus($id, $token)
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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

			if(isset($id) && !empty($id))
			{
				$profil = $this->UsersModel->getProfil($id);

				if(!empty($profil))
				{

					$status = null;

					if($profil->active == 1)
					{
						$status = 0;
					}
					else
					{
						$status = 1;
					}

					$this->UsersModel->admin_setStatus($id, $status);

					session_deleteKey('token');

					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash("Le status du compte a été changée.", 'alertSuccess');
					die();
				}
				else
				{
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash("Le compte n'existe pas.", 'alertError');
					die();
				}
			}
			else
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
				session_setFlash("Le compte n'existe pas.", 'alertError');
				die();
			}
		}

		/**
		 * admin_changePermission
		 *
		 * Permet de changer la permission du compte
		 *
		 * @param id id du compte
		 * @param token jeton csrf
		 **/

		public function admin_changePermission($id, $token)
		{
			// test si il est admin
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
			{
				if($_SESSION['auth']['permission'] != 'admin')
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

			if(isset($id) && !empty($id))
			{
				$profil = $this->UsersModel->getProfil($id);

				if(!empty($profil))
				{
					$permission = $profil->permission;

					if(!empty($_POST))
					{
						$this->UsersModel->admin_setPermission($id, $_POST['permission']);

						session_deleteKey('token');

						header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
						session_setFlash("La permission a été changée.", 'alertSuccess');
						die();
					}

				}
				else
				{
					session_deleteKey('token');

					header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
					session_setFlash("Le compte n'existe pas.", 'alertError');
					die();
				}
			}
			else
			{
				session_deleteKey('token');

				header('Location: '.URL_PAGES.'users/index.php?function=admin_list');
				session_setFlash("Le compte n'existe pas.", 'alertError');
				die();
			}

			// Chargement du de la vue
			include ROOT_PAGES.'users/view/admin_changePermission.php';	
		}
	}	
?>	