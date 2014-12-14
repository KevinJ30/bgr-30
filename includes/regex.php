<?php
	/**
	 * File : Includes/regex.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Contient toutes les regex
	 **/

	/**
	 * Détermine si la chaine contient au moin une majuscule
	 **/
	function checkUpper($chaine)
	{
		$regex = "#[A-Z]#";
		if(preg_match($regex, $chaine))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Détermine si l'adresse e-mail est valide
	 **/
	function checkMail($chaine)
	{
		$regex = "#^[a-zA-Z0-9._-]+@[a-zA-Z]{2,}\.[a-z]{2,4}$#";
		// kev.joudrier@gmail.com
		if(preg_match($regex, $chaine))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Détermine si c'est une chaine alphanumeric
	 **/
	function checkAlphaNumeric($chaine)
	{
		$regex = "#^[a-zA-Z0-9]+$#";

		if(preg_match($regex, $chaine))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Détermine le minimum de caractère
	 **/
	function minLength($chaine, $minLength)
	{
		if(strlen($chaine) >= $minLength)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Détermine si la chaine est au format numeric
	 **/
	function checkNumeric($chaine)
	{
		if(is_numeric($chaine))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
?>