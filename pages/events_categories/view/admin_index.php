<?php
	/**
	 * File : pages/events_categories/view/admin_index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la liste des categories
	 **/

	$title = "Liste des catégories";

	// charge le header
	include_once ROOT_TEMPLATE.'headerAdmin.php';

	$token = session_generateToken(true);
?>
	<article>
		<h1>Liste des catégories</h1>
		<a href="<?= URL_PAGES.'events_categories/index.php?function=admin_add&token='.$token ?>" class="button"><button class="site vert">Ajouter une catégorie</button></a>
		<table>
			<tbody>
				<tr>
					<th>Titre</th>
					<th>Color</th>
					<th>Actif</th>
					<th>Editer</th>
					<th>Supprimer</th>
				</tr>
				
				<?php 
					if(!$categories)
					{
						echo '<tr><td COLSPAN="6">Aucune catégorie présente sur le site.</td></tr>';
					}
				?>

				<?php foreach($categories as $v) : ?>

				<tr class="alt-row">
					<td><?= $v->name; ?></td>
					<td><?= $v->color; ?></td>
					<td><button class="<?= $v->actif == 1 ? "site vert" : "site rouge" ?> alignCenter" disabled="disabled"><?= $v->actif == 1 ? "Publier" : "Hors ligne" ?></button></td>
					<td><a href="<?= URL_PAGES.'events_categories/index.php?function=admin_edit&id='.$v->id.'&token='.$_SESSION['token']; ?>" class="button"><button class="site vert alignCenter">Editer</button></a></td>
					<td><a href="<?= URL_PAGES.'events_categories/index.php?function=admin_delete&id='.$v->id.'&token='.$_SESSION['token']; ?>" class="button" onclick="return(confirm('Etes-vous sur de vouloir cet article ?'));"><button class="site orange alignCenter">Supprimer</button></a></td>
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