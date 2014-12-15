<?php
	/**
	 * File : class/Validator.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient les fonction de validation de données
	 **/

	class Validator
	{

		// attribue public de la class
		public $errorMessage = array(); // Tableau contenant touts les message d'erreur de validation

		// Attribue privé de la class
		private $validates = array(); // Contient le tableau de validation
		private $model = null; // Stock le model du controller
		private $table = null;
		private $vars = array();
		private $error = false;

		/**
		 * Constructeur de la class
		 *
		 * @param $validates : contient le tableau de validation
		 * @param $table : contient la tableu sur laquel on traivaille
		 * @param $securVars : permet de traiter les faille xss
		 * @return : retourne le tableau d'erreur
		 **/

		public function __construct($validates = array(), $model = null, $table = null, $securVars = false)
		{
			$this->validates = $validates;

			// initialise l'attribue model
			$this->model = $model;
			$this->table = $table;

			if($securVars)
			{
				foreach($_POST as $k=>$v)
				{
					$_POST[$k] = htmlentities($v);
				}
			}

			$this->vars = $_POST;

			// initialise la vairbale errorMessage
			foreach($_POST as $k=>$v)
			{
				$this->errorMessage[$k]['chaine'] = $_POST[$k];
				$this->errorMessage[$k]['message'] = null;
			}



			// On execute la validation des données
			$this->exec();
		}

		/** Formatage du tableau de validation
		  array(
			'username' => array(
				'upper' => array(
					'rule' => 'upper',
					'message' => 'Votre chaçine doit comporter au moin une majuscule'
				)
			)
		  )
		 **/

		/**
		 * Permet d'executer les méthode de validation
		 *
		 * la fonction permet d'afficher que le première erreur générer
		 * Attention à l'ordre des validations
		 **/
		private function exec()
		{
			// On parcourt la tableau de validation
			foreach($this->validates as $key=>$value)
			{
				$champs = $key;
				$params = null;


				// On parcourt le tableau de régle associer au champs
				foreach($value as $k)
				{
					 // On stock les régle et le message d'erreur générer
					$rule = null;
					$message = $k['message'];

					if(is_array($k['rule']))
					{
						$rule = $k['rule'][0];
						$params = array_slice($k['rule'], 1);
					}
					else
					{
						$rule = $k['rule'];
					}

					// Exécution des fonction

					// On test que la fonction de la régle existe sinon on ne fait rien
					if(method_exists($this, $rule))
					{
						// On test que le champ existe
						if(isset($_POST[$champs]))
						{
							// On execute la fonction
							$result = call_user_func_array(array($this, $rule), array(array('champs' => $champs, 'value' => $_POST[$champs]), $params));

							// Si une erreur c'est produite lors de la validation
							// on rentre l'erreur dans le tableau d'erreur
							if(!$result)
							{
								if($this->errorMessage[$champs]['message'] == null)
								{
									$this->errorMessage[$champs]['message'] = $message;
								}
							}
						}
					}
				}
			}
		}

		/**
		 * Permet de savoir si il y a une erreur sur le formulaire
		 *
		 * @return : retourne true si il y a pas d'erreur sur le formulaire
		 **/
		public function validates()
		{
			$erreur = null;

			// Parcour du tableaux
			foreach($this->errorMessage as $k=>$v)
			{
				if($this->errorMessage[$k]['message'] != null)
				{
					$erreur =+ 1;
				}
			}

			if($erreur > 0)
			{
				return false;
			}

			return true;
		}


		/**
		 * Régle de validation
		 **/

		// Détermine si le champs est vide
		public function notEmpty($chaine)
		{
			if(!empty($chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Détermine si la chaine contient au moin une majuscule
		public function upper($chaine)
		{
			$regex = "#[A-Z]#";

			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Détermine que la chaine soit au format alphanumeric
		public function alphaNumeric($chaine)
		{
			$regex = "#^[a-zA-Z0-9éàèùîûêâç\'\,\.\!\?\^ -_.]+$#";

			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Test si la chaine est au format numeric
		public function numeric($chaine)
		{
			if(is_numeric($chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Détermine le minimum de caractères sur la chaine
		public function minLength($chaine, $params)
		{
			if(strlen($chaine['value']) >= $params[0])
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// test si la chaine existe dans la base de donnée
		public function unique($chaine)
		{
			// On se connect à la base de données
			$this->model->connect();

			$req = $this->model->bdd->prepare('SELECT id FROM '.$this->table.' WHERE '.$chaine['champs'].'=:'.$chaine['champs']);

			$req->execute(array(
				$chaine['champs'] => $chaine['value']
			)) or die(print_r($req->errorInfo()));

			$donnees = $req->fetch(PDO::FETCH_OBJ);

			if(empty($donnees))
			{
				return true;
			}
			else
			{
				return false;
			}


		}

		// Test si deux champs sont égal
		public function egalTo($chaine, $params)
		{
			if($chaine['value'] == $_POST[$params[0]])
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Test si le champ est au format mail
		public function mail($chaine)
		{
			$regex = "#^[a-zA-Z0-9._-]+@[a-zA-Z]{2,}\.[a-z]{2,4}$#";

			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Test si le champs est au format d'une date
		public function date($chaine)
		{
			// régle
			$regex = "#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#";

			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Test si le champs est au format heure : minute
		public function time($chaine)
		{
			// régle
			$regex = "#^[0-9]{2}:[0-9]{2}$#";

			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}


		// Test si le champ est au format numéro de téléphone
		public function phone($chaine)
		{

			$regex = "#^0[0-9 -_.][0-9 -_.]{8}#";
			
			if(preg_match($regex, $chaine['value']))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
		 * ------------------ END regle de validation ----------------
		 **/
	}
?>