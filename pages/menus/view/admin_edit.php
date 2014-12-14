<?php
	/**
	 * File : pages/menus/view/admin_index.php
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
				<legend>Editer un menu</legend>
				<div class="input">
					<label>Nom du menu :</label>
					<input type="text" name="name" value="<?= isset($validator->errorMessage['name']['chaine']) ? $validator->errorMessage['name']['chaine'] : $name; ?>">
					<label class="error"><?= isset($validator->errorMessage['name']['chaine']) ? $validator->errorMessage['name']['message'] : null; ?></label>
				</div>
			</fieldset>
			<div class="input">
				<input type="submit" value="Valider">
			</div>
		</form>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>