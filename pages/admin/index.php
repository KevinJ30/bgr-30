<?php
	require '../../includes/includes.php';

	if(isset($_SESSION['auth']))
	{
		if($_SESSION['auth']['permission'] != 'admin' && $_SESSION['auth']['permission'] != 'autheur')
		{
			$message = "Accès refusé.";
			include ROOT.'errors/error403.php';
			die();
		}	
	}
	else
	{
		$message = "Accès refusé.";
		include ROOT.'errors/error403.php';
		die();	
	}
	// Chargement du design
	include_once(ROOT_TEMPLATE.'/headerAdmin.php');
?>
<div id="content">
	<h1>Bienvenue sur la page d'accueil du site</h1>
</div>
<?php
	// Chargement du footer
	include_once(ROOT_TEMPLATE.'/footer.php');
?>