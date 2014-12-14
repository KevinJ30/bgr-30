<?php
	/**
	 * File : includes/constants.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient les constantes utiles
	 **/

	// Chemins
	$chemin = explode('/', $_SERVER['SCRIPT_FILENAME']);
	$URL = array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 1);

	// ROOT
	define('__DS__', DIRECTORY_SEPARATOR);
	define('ROOT', $chemin[0].__DS__.$chemin[1].__DS__.$chemin[2].__DS__.$chemin[3].__DS__);
	define('ROOT_TEMPLATE', ROOT.'template'.__DS__);
	define('ROOT_PAGES', ROOT.'pages'.__DS__);
	// ------- END ----------

	// URL
	define('URL_ROOT', '/'.$URL[0].'/');
	define('URL_PAGES', '/'.$URL[0].'/'.'pages/');
	define('URL_TEMPLATE', '/'.$URL[0].'/'.'template/');
	// ----------- END -----------
?>