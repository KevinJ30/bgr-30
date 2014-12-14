<?php
	/**
	 * File : pages/pages/view/index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la page d'accueil du site
	 **/

	$title = "Liste des articles";

	// charge le header
	include_once ROOT_TEMPLATE.'headerAdmin.php';

	$token = session_generateToken(true);
?>
	<article>
		<h1>Liste des articles du site</h1>
		<a href="<?= URL_PAGES.'pages/index.php?function=admin_create&token='.$token ?>" class="button"><button class="site vert">Ajouter un article</button></a>
		<table>
			<tbody>
				<tr>
					<th>title</th>
					<th>date de création</th>
					<th>Status</th>
					<th>Accueil</th>
					<th>Menu</th>
					<th>Editer</th>
					<th>Supprimer</th>
				</tr>

				<?php foreach($pages as $v) : ?>

				<tr class="alt-row">
					<td><?= $v->title; ?></td>
					<td><?= $v->date; ?></td>
					<td><button class="<?= $v->status == 1 ? "site vert" : "site rouge" ?> alignCenter" disabled="disabled"><?= $v->status == 1 ? "Publier" : "Hors ligne" ?></button></td>
					<td><?= $v->accueil; ?></td>
					<td><small><?= $v->menu_name != null ? $v->menu_name : "Aucun menu associé." ?></small></td>
					<td><a href="<?= URL_PAGES.'pages/index.php?function=admin_edit&id='.$v->id.'&token='.$token ?>" class="button"><button class="site vert alignCenter">Editer</button></a></td>
					<td><a href="<?= URL_PAGES.'pages/index.php?function=admin_delete&id='.$v->id.'&token='.$token ?>" class="button" onclick="return(confirm('Etes-vous sur de vouloir cet article ?'));"><button class="site orange alignCenter">Supprimer</button></a></td>
				</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
	</article>
	<!-- Chargement de l'editeur wysiwyng -->
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce.js"></script>
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce_load.js"></script>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>
