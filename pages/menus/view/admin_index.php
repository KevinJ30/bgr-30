<?php
	/**
	 * File : pages/menus/view/admin_index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la list des menu du site
	 **/

	// Titre de la page
	$title = 'Liste menus';

	// Chargement du header
	include_once ROOT_TEMPLATE.'headerAdmin.php';

	$token = session_generateToken(true);

	if(empty($menus))
	{
		$name = "Aucun menu sur le site.";
	}
?>
	<article>
		<div class="alignCenter large-4">
			<h1>Liste des menus</h1>
			<a href="<?= URL_PAGES.'menus/index.php?function=admin_add&token='.$token; ?>" class="button"><button class="site vert">Ajouter</button></a>
			<table>
				<tbody>
				<tr>
					<th>Nom</th>
					<th>Editer</th>
					<th>Supprimer</th>
				</tr>
		<?php
			if(isset($name)):
		?>
				<tr>
					<td><?= $name ?></td>
					<td>Aucunes actions possibles</td>
				</tr>
		<?php
			endif;
		?>

		<?php
			foreach($menus as $v) :
		?>
				<tr>
					<td><?= $v->name; ?></td>
					<td><a href="<?= URL_PAGES.'menus/index.php?function=admin_edit&id='.$v->id.'&token='.$token; ?>" class="button"><button class="site vert alignCenter">Editer</button></a></td>
					<td><a href="<?= URL_PAGES.'menus/index.php?function=admin_delete&id='.$v->id.'&token='.$token; ?>" class="button" onclick="return(confirm('Etes-vous sur de vouloir supprimer le menu?'));"><button class="site orange alignCenter">Supprimer</button></a></td>
				</tr>
		<?php		
			endforeach;
		?>
				</tbody>
			</table>
		</div>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>