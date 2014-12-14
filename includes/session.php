<?php
	/**
	 * File : includes/session.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Gére les session du site
	 **/

	session_start();

	// On initialise une valeur par défaut au token
	if(!isset($_SESSION['token']))
	{
		$_SESSION['token'] = null;
	}

	/**
	 * Permet de détruire la session actuel
	 **/
	function session_destroySession()
	{
		session_destroy();
	}

	/**
	 * Permet de supprimer une clé dans la session
	 **/
	function session_deleteKey($key)
	{
		unset($_SESSION[$key]);
	}

	/**
	 * Permet d'afficher un message flash sur le site
	 **/
	function session_setFlash($message, $type = NULL)
	{
		$_SESSION['flash'] = array(
			'type' => $type,
			'message' => $message
		);

		return true;
	}

	/**
	 * Permet d'afficher les message flash
	 **/
	function session_drawFlash()
	{
		if(isset($_SESSION['flash']) && !empty($_SESSION['flash']))
		{
			switch($_SESSION['flash']['type'])
			{
				default :
					echo $_SESSION['flash']['message'];
				break;

				case 'alertSuccess':
					echo '<div class="pannel-box success">';
						echo '<p>'.$_SESSION['flash']['message'].'</p>';
						echo '<a href="#" class="close">&times;</a>';
					echo '</div>';
				break;

				case 'alertWarning':
					echo '<div class="pannel-box warning">';
						echo '<p>'.$_SESSION['flash']['message'].'</p>';
						echo '<a href="#" class="close">&times;</a>';
					echo '</div>';
				break;

				case 'alertError':
					echo '<div class="pannel-box error">';
						echo '<p>'.$_SESSION['flash']['message'].'</p>';
						echo '<a href="#" class="close">&times;</a>';
					echo '</div>';
				break;
			}
		}

		// On supprime le message flash
		session_deleteKey('flash');
	}

	/**
	 * Permet de g�n�rer un token
	 *
	 * @param : $session permet de stocker ou non le token dans la session actuel
	 **/
	function session_generateToken($session = NULL)
	{
		// On récupere les clés
		$key = Config::$encrypt;
		$keyNum = Config::$encryptNum;

		// Convertie la chaine en tableau
		$key = preg_split('//', $key);
		$keyNum = preg_split('//', $keyNum);

		$countKey = count($key);
		$countKeyNum = count($keyNum);

		$token = null;

		// On genére le token
		for($i = 0; $i < 50; $i++)
		{
			$token .= $key[rand(0, $countKey - 1)];
			$token .= $keyNum[rand(0, $countKeyNum - 1)];
		}

		// Encryptage suplèmentaire
		$token = sha1($token);

		if($session)
		{
			if(!isset($_SESSION['token']) && empty($_SESSION['token']))
			{
				$_SESSION['token'] = $token;
			}

			return $_SESSION['token'];
		}

		return $token;
	}

