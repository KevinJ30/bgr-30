<?php
	/**
	 * File : includes/updateAuth.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet de mettre a jour la session auth
	 **/

	// Si on est connecté au site on remet a jour les données du compte en session

	if(isset($_SESSION))
	{
		if(isset($_SESSION['auth']))
		{
			// Instance de la class PDO
			$bdd = new PDO('mysql:host=localhost;dbname=bgr30', 'root', '');

			$req = $bdd->prepare('SELECT id, username, password, nom, prenom, mail, created, permission, avatar, type_token, token FROM users WHERE id=:id');

			$req->execute(array(
				'id' => $_SESSION['auth']['id']
			));

			$donnees = $req->fetch(PDO::FETCH_OBJ);

			$_SESSION['auth']['id'] = $donnees->id;
			$_SESSION['auth']['username'] = $donnees->username;
			$_SESSION['auth']['password'] = $donnees->password;
			$_SESSION['auth']['nom'] = $donnees->nom;
			$_SESSION['auth']['prenom'] = $donnees->prenom;
			$_SESSION['auth']['mail'] = $donnees->mail;
			$_SESSION['auth']['created'] = $donnees->created;
			$_SESSION['auth']['permission'] = $donnees->permission;
			$_SESSION['auth']['avatar'] = $donnees->avatar;
			$_SESSION['auth']['type_token'] = $donnees->type_token;
			$_SESSION['auth']['token'] = $donnees->token;
		}
	}

?>