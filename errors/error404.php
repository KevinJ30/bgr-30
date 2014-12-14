<?php
	// Status de la page
	header("HTTP/1.0 404 Not Found");
	include ROOT_TEMPLATE.'error_header.php';
?>

<h1>Erreur 404</h1>
<p><?= $message ?></p>
<p><small><a href="<?= URL_ROOT.'index.php'; ?>">Revenir sur le site</a></small></p>
<?php
	include ROOT_TEMPLATE.'error_footer.php';
?>