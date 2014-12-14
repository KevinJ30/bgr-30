<?php
	/**
	 * File : pages/pages/view/index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la page d'accueil du site
	 **/

	$title = "Accueil";

	// charge le header
	include_once ROOT_TEMPLATE.'header.php';
?>
	<article>
		<?php
			foreach($accueil as $v) :
		?>
			<h1><?= $v->title; ?><small>Créé le : <?= $v->date; ?></small></h1>
			<p><?= $v->content; ?></p>
		<?php
			endforeach;
		?>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>