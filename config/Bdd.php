<?php
	/**
	 * File : config/Bdd.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient la configuration de la base de donnée
	 **/

	abstract class BddConfig
	{
		public static $default = array(
			'host' => 'localhost',
			'identifiant' => 'root',
			'password' => '',
			'basename' => 'bgr30',
			'encodage' => 'utf8'
		);
	}
?>