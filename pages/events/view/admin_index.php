<?php
	/**
	 * File : pages/news/view/admin_index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche les news sur le site
	 **/

	$title = "Liste des événement";

	// charge le header
	include_once ROOT_TEMPLATE.'headerAdmin.php';

	$token = session_generateToken(true);
?>
	<article>
		<h1>Liste des événement</h1>
		<a href="<?= URL_PAGES.'events/index.php?function=admin_add&token='.$token ?>" class="button"><button class="site vert">Ajouter un événement</button></a>
		<table>
			<tbody>
				<tr>
					<th>Titre</th>
					<th>Date de début</th>
					<th>Date de fin</th>
					<th>Heure de début</th>
					<th>Heure de fin</th>
					<th>Status</th>
					<th>Categorie</th>
					<th>Supprimer</th>
					<th>Editer</th>
				</tr>
				
				<?php 
					if(!$events)
					{
						echo '<tr><td COLSPAN="6">Aucune événemnt présente sur le site.</td></tr>';
					}
				?>
				
				<?php foreach($events as $v) : ?>

				<tr class="alt-row">
					<td><?= $v->title; ?></td>
					<td><?= $v->date_start; ?></td>
					<td><?= $v->date_end; ?></td>
					<td><?= $v->heure_start; ?></td>
					<td><?= $v->heure_end; ?></td>
					<td><?= $v->categorieName; ?></td>
					<td><button class="<?= $v->actif == 1 ? "site vert" : "site rouge" ?> alignCenter" disabled="disabled"><?= $v->actif == 1 ? "Publier" : "Hors ligne" ?></button></td>
					<td><a href="<?= URL_PAGES.'events/index.php?function=admin_edit&id='.$v->id.'&token='.$token ?>" class="button"><button class="site vert alignCenter">Editer</button></a></td>
					<td><a href="<?= URL_PAGES.'events/index.php?function=admin_delete&id='.$v->id.'&token='.$token ?>" class="button" onclick="return(confirm('Etes-vous sur de vouloir cet article ?'));"><button class="site orange alignCenter">Supprimer</button></a></td>
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
