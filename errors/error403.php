<?php
	header("HTTP/1.0 403 Forbidden");
	include ROOT_TEMPLATE.'error_header.php';
?>
		<h1>Erreur 403</h1>
		<p><?= $message ?></p>
		<p><small><a href="<?= URL_ROOT.'index.php'; ?>">Revenir sur le site</a></small></p>
<?php
	include ROOT_TEMPLATE.'error_footer.php';
?>