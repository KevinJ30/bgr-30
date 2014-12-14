<?php
	/**
	 * File : includes/fonctions.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient les fonctions global au site 
	 **/

	/**
	 * permet d'afficher la superGlobal session
	 **/
	function debugSession()
	{
		if(Config::$debug > 0)
		{
			echo '<h2>Debug Session : </h2>';
			var_dump($_SESSION);
		}
	}

	/**
	 * Effectue un var_dump avec un arrêt
	 * 
	 **/
	function debug($donnees = array())
	{
		if(Config::$debug > 0)
		{
			var_dump($donnees);
			die();	
		}
	}
?>