<?php
	/**
	 * File : class/Model.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Fonction pour la gestion de la BDD
	 **/

	class Model
	{

		public $bdd; // Instance de la class PDO
		public $table; // La table charger par défaut et le nom du controller

		// initalisation des variable

		public function __construct($table)
		{
			$this->table = strtolower($table);
		}

		public function connect()
		{
			// Connection a la base de donnée
			try
			{
				$this->bdd = new PDO('mysql:host='.BddConfig::$default['host'].';dbname='.BddConfig::$default['basename'], BddConfig::$default['identifiant'], BddConfig::$default['password']);
				// Encodage en base de données
				$this->bdd->exec('set names utf8');
			}
			catch(Exception $e)
			{
				if(Config::debug > 0)
				{
					die('Erreur : '.$e->getMessage());
				}
				else
				{
					echo 'Impossible de joindre le server.';
				}
			}
		}
	}
?>