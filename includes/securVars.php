<?php
	/**
	 * File : includes/securVars.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet de securiser les variable sensible du site
	 **/

	/**
	 * Globals
	 **/
	// Get
	if(isset($_GET))
	{
		foreach($_GET as $key=>$value)
		{
			$_GET[htmlentities($key)] = htmlentities($value);
		}
	}

	/**
	 * Permet de sécuriser les données rentré dans une formulaire
	 **/
	function securPost($vars = array())
	{
		foreach($vars as $k=>$v)
		{
			$_POST[$k] = htmlentities($v);
		}
	}
?>