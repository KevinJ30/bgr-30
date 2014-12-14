<?php
	/**
	 * File : pages/pages/view/view.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * affiche l'article que l'on a demander
	 **/

	$title = $page->title;

	// charge le header
	include_once ROOT_TEMPLATE.'header.php';
?>
	<article>
		<h1><?= $page->title; ?><small>Créé le : <?= $page->date; ?></small></h1>
		<p><?= $page->content; ?></p>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>