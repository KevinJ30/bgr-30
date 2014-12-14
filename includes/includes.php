<?php
	/**
	 * File : includes/includes.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Inclut les fichier néccessaire au bon fonctionnement du site
	 **/

	// Fichier

	require 'constants.php';
	require 'functions.php';
	require 'securVars.php';
	require 'session.php';
        require 'date.php';
	require 'regex.php';
	require 'updateAuth.php';

	// Config
	require ROOT.'config/Bdd.php';
	require ROOT.'config/Config.php';

	// Class
	require ROOT.'class/Controller.php';
	require ROOT.'class/Model.php';
	require ROOT.'class/Validator.php';
?>