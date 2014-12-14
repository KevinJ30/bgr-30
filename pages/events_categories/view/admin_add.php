<?php
	/**
	 * File : pages/events_categories/view/admin_add.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la list des menu du site
	 **/

	// Titre de la page
	$title = 'Ajouter un menu';

	// Chargement du header
	include_once ROOT_TEMPLATE.'headerAdmin.php';
?>
	<article>
		<form method="POST" action="#" class="large-6 alignCenter">
			<fieldset>
				<legend>Ajouter une categorie</legend>
				<div class="input">
					<label>Nom de la catégorie :</label>
					<input type="text" name="name" value="<?= isset($validator->errorMessage['name']['chaine']) ? $validator->errorMessage['name']['chaine'] : null; ?>">
					<label class="error"><?= isset($validator->errorMessage['name']['chaine']) ? $validator->errorMessage['name']['message'] : null; ?></label>
				</div>
				<div class="input">
					<label>Couleur de la catégorie :</label>
					<input type="text" name="color" value="<?= isset($validator->errorMessage['color']['chaine']) ? $validator->errorMessage['color']['chaine'] : null; ?>">
					<label class="error"><?= isset($validator->errorMessage['color']['chaine']) ? $validator->errorMessage['color']['message'] : null; ?></label>
				</div>
				<div class="input">
					<input type="checkbox" name="actif" value="1" /><label>Voulez-vous directement publier cette categorie ?</label>
				</div>
			</fieldset>
			<div class="input">
				<input type="submit" value="Ajouter">
			</div>
		</form>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>