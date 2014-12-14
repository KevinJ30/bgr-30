<?php
	/**
	 * File : pages/users/UsersModel.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient toutes les requête utilisé par le script users
	 **/
	class UsersModel extends Model
	{

		/**
		 * Permet de savoir si c'est la bonne personne qui se connecte au site
		 **/
		public function getUser($utilisateur = array())
		{
			// établie la connection a la base de donnée 
			$this->connect();

			$req = $this->bdd->prepare('SELECT id, username, password, nom, prenom, mail, created, permission, active, avatar, type_token, token FROM users WHERE username= :username');

			$req->execute(array(
				'username' => $utilisateur['username']
			)) or die(print_r($this->bdd->errorInfo()));

			$donnees = $req->fetch(PDO::FETCH_OBJ);
			$req->closeCursor();

			return $donnees;
		}

		/**
		 * Test si le pseudo existe dans la base de donnée
		 *
		 * @param : $username l'identifiant de la personne
		 * @return : true si il existe sinon false
		 **/
		public function check_username($username)
		{
			// établie la connection dans à la base de données
			$this->connect();

			$req = $this->bdd->prepare('SELECT id FROM users WHERE username = :username');

			// On execute la requete
			$req->execute(array(
				'username' => $username
			)) or die(print_r($this->bdd->errorInfo()));

			$donnees = $req->fetch(PDO::FETCH_OBJ);

			$req->closeCursor();

			if($donnees)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
		 * Test si la licence correspond a la personne qui s'enregistre sur le site
		 *
		 * @param : $licence : contient le numero de licence
		 * @param : $nom : contient le nom de l'utilisateur
		 * @param : $prenom :contient le prenom de l'utilisateur
		 *
		 * @return : retourne true si il fait partie du club sinon retourne false
		 **/

		public function check_licence($licence, $nom, $prenom)
		{

			// établie la connection a la base de donnée
			$this->connect();

			$req = $this->bdd->prepare('SELECT nom, prenom FROM pouna WHERE licence= :licence');

			// On execute la requete
			$req->execute(array(
				'licence' => $licence
			)) or die(print_r($this->bdd->errorInfo()));

			$donnees = $req->fetch(PDO::FETCH_OBJ);

			$req->closeCursor();

			if(!empty($donnees))
			{
				if((strtolower($donnees->nom) == strtolower($nom)) && (strtolower($donnees->prenom) == strtolower($prenom)))
				{
					return true;
				}	
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		/**
		 * Permet d'enregistrer le compte dans la base de données
		 *
		 * @param : $utilisateur : contient les données poster par l'utilisateur
		 **/
		public function register($utilisateur = array())
		{
			// etablie la connection à la base de données
			$this->connect();

			$req = $this->bdd->prepare("INSERT INTO users(username, password, nom, prenom, mail, licence, created, permission, active, banned, type_token, token) VALUES(:username, :password, :nom, :prenom, :mail, :licence, NOW(), :permission, :active, :banned, :type_token, :token)");

			$req->execute($utilisateur) or die(print_r($this->bdd->errorInfo()));

			$req->closeCursor();

			return true;
		}

		/**
		 * Permet a l'utilisateur d'activer sont compte
		 *
		 * @param : $username l'identifiant de l'utilisateur
		 * @return : retourne false si le lien n'est pas valide
		 **/
		public function activate($username, $token)
		{
			// Établie la connection a la base de données
			$this->connect();

			// requête sql
			$req = $this->bdd->prepare('SELECT id, active, type_token, token FROM users WHERE username=:username');

			$req->execute(array('username' => $username))or die(print_r($req->errorInfo()));

			$donnees = $req->fetch(PDO::FETCH_OBJ);

			// Si des données existe 
			if(!empty($donnees))
			{
				if($donnees->type_token == 'active' && $donnees->token == $token)
				{
					// Si tout c'est bien passer on active le compte et reset le token
					$req = $this->bdd->prepare("UPDATE users SET active=:active, type_token=:type_token, token=:token WHERE id=:id");

					$req->execute(array(
						'active' => 1,
						'type_token' => null,
						'token' => null,
						'id' => $donnees->id
					)) or die(print_r($req->errorInfo()));

					$req->closeCursor();
					return true;
				}
				else
				{
					echo'111';
					return false;
				}
			}
			else
			{
				return false;
			}
		}


		/**
		 * getProfil
		 *
		 * Permet de retourner les information du compte de l'utilisateur
		 * @param $id : contient l'id du compte
		 **/
		public function getProfil($id)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('SELECT id, username, password, tmp_password, nom, prenom, mail, created, permission, active, type_token, token FROM users WHERE id=:id');

			$req->execute(array(
				'id' => $id
			)) or die(print_r($req->errorInfo()));

			return $req->fetch(PDO::FETCH_OBJ);

			$req->closeCursor(); // On ferme la connection
		}

		/**
		 * updateUsername
		 *
		 * Permet de changer l'identifiant
		 * @param : $id : id du compte
		 **/

		public function updateUsername($username, $id)
		{
			// Connection à la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET username=:username WHERE id=:id');

			$req->execute(array(
				'username' => $username,
				'id' => $id
			));

			$req->closeCursor();
		}

		/**
		 * updateMail
		 *
		 * Permet de changer l'adresse e-mail
		 * @param : $mail :contient la nouvel adresse mail
		 * @param : $id contient l'id du compte a modifié
		 **/

		public function updateMail($mail, $id)
		{
			// Connection a la base de donnée
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET mail=:mail WHERE id=:id');

			$req->execute(array(
				'mail' => $mail,
				'id' => $id
			)) or die(print_r($req->errorInfo()));

			// Fermeture de la connection
			$req->closeCursor();
		}

		/**
		 * updatePassword
		 *
		 * Permet de changer sont mot de passe
		 * @param : $actuPassword : contient le mot de passe actuel
		 * @param : $password : conteint le nouveau password
		 * @param : $id
		 **/

		public function updatePassword($donnees = array())
		{
			// connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET tmp_password=:tmp_password, active=:active, type_token=:type_token, token=:token WHERE id=:id');

			$req->execute(array(
				'tmp_password' => $donnees['password'],
				'active' => $donnees['active'],
				'type_token' => $donnees['type_token'],
				'token' => $donnees['token'],
				'id' => $donnees['id']
			)) or die(print_r($req->errorInfo()));

			// Fermeture de la connection
			$req->closeCursor();
		}

		/**
		 * confirPassword
		 *
		 * Permet de changer sont mot de passe
		 * @param $password contient le nouveau mot de passe
		 * @param $check : contient permet d'annuler la demande
		 * @param $id :contien l'id du compte
		 **/
		public function confirmPassword($password, $check, $id)
		{
			// connection a la base de données
			$this->connect();

			if($check == 'true')
			{
				$req = $this->bdd->prepare('UPDATE users SET password=:password, tmp_password=:tmp_password, active=:active,  type_token=:type_token, token=:token WHERE id=:id');

				$req->execute(array(
					'password' => $password,
					'tmp_password' => null,
					'active' => 1,
					'type_token' => null,
					'token' => null,
					'id' => $id
				));
			}
			else
			{
				$req = $this->bdd->prepare('UPDATE users SET tmp_password=:tmp_password, active=:active,  type_token=:type_token, token=:token WHERE id=:id');

				$req->execute(array(
					'tmp_password' => null,
					'active' => 1,
					'type_token' => null,
					'token' => null,
					'id' => $id
				)) or die($req->errorInfo());
			}

			// Fermeture de la connection
			$req->closeCursor();
		}

		/**
		 * getToken
		 *
		 * Permet de lire le token du compte
		 *
		 * @param $id : id du compte
		 * @return : retourne un tableau contenet le token et le type de token du compte
		 **/
		public function getToken($id)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('SELECT type_token, token FROM users WHERE id=:id');

			$req->execute(array(
				'id' => $id	
			)) or die($req->errorInfo());
		}

		/**
		 * add
		 *
		 * Permet d'ajouter un compte via l'administration
		 * @param : $donnes contient les données & envoyer
		 **/
		public function add($donnees)
		{

			// Connection à la base de données 
			$this->connect();

			$req = $this->bdd->prepare("INSERT INTO users(username, password, nom, prenom, created, permission, active) VALUES(:username, :password, :nom, :prenom, NOW(), :permission, :active)");
			
			$req->execute(array(
				'username' => $donnees['username'],
				'password' => $donnees['password'],
				'nom' => $donnees['nom'],
				'prenom' => $donnees['prenom'],
				'permission' => $donnees['permission'],
				'active' => $donnees['active']
			)) or die(print_r($req->errorInfo()));

			$req->closeCursor();
		}


		/**
		 * getCompte
		 *
		 * Permet de récupérer tout les compte du site
		 **/
		public function getComptes()
		{

			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->query('SELECT id, username, nom, prenom, mail, permission, active FROM users');

			$comptes = array();

			while($donnees = $req->fetch(PDO::FETCH_OBJ))
			{
				$comptes[] = $donnees;
			}

			return $comptes;
			// Fermeture de la connection
			$req->closeCursor();
		}

		/**
		 * deleteCompte
		 *
		 * Permet de supprimer un compte
		 *
		 * @param $id id du compte
		 **/
		public function deleteCompte($id)
		{
			// Connec-tion a la base de donnée
			$this->connect();

			$req = $this->bdd->prepare('DELETE FROM users WHERE id=:id');

			$req->execute(array(
				'id' => $id
			));

			$req->closeCursor();
		}

		/**
		 * admin_edit
		 *
		 * permet de mettre a jour un compte
		 **/
		public function admin_edit($utilisateur = array())
		{

			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET username = :username, nom=:nom, prenom=:prenom, password=:password, permission=:permission, active=:active WHERE id=:id');

			$req->execute(array(
				'username' => $utilisateur['username'],
				'password' => $utilisateur['password'],
				'nom' => $utilisateur['nom'],
				'prenom' => $utilisateur['prenom'],
				'permission' => $utilisateur['permission'],
				'active' => $utilisateur['active'],
				'id' => $utilisateur['id']

			)) or die(print_r($req->errorInfo()));

			$req->closeCursor();
		}

		/**
		 * admin_status
		 *
		 * @param $id id du compte
		 **/
		public function admin_setStatus($id, $status)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET active=:active WHERE id=:id');

			$req->execute(array(
				'active' => $status,
				'id' => $id
			));

			$req->closeCursor();
		}

		/**
		 * admin_setPermission
		 *
		 * @param $id id du compte
		 **/
		public function admin_setPermission($id, $permission)
		{
			// Connection a la base de données
			$this->connect();

			$req = $this->bdd->prepare('UPDATE users SET permission=:permission WHERE id=:id');

			$req->execute(array(
				'permission' => $permission,
				'id' => $id
			));

			$req->closeCursor();
		}		
	}
?>
