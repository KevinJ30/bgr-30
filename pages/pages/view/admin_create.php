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
	include_once ROOT_TEMPLATE.'headerAdmin.php';
?>
	<article>
		<h1>Ajouter un article sur le site</h1>

		<form action="#" method="POST">
			<div class="input input-row large-5">
				<label>Titre de l'article :</label>
				<input type="text" name="title" placeholder="Titre de l'article" value="<?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['chaine'] : null; ?>" />
				<label class="error"><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['message'] : null; ?></label>
			</div>

			<div class="input input-row">
				<label>Associer à un menu :</label>
				<select name="menu" class="large-12">
					<?php foreach ($menus as $value) : ?>
						<option value="<?= $value->id ?>"><?= $value->name; ?></option>
					<?php endforeach; ?>
					<option value="0" selected="selected">Aucun</option>
				</select>
				<label class="error"><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['message'] : null; ?></label>
			</div>
			<div class="clear-both"></div>

			<div class="input">
				<textarea name="content" placeholder="Insérer le contenu de votre article."><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['content']['chaine'] : null; ?></textarea>
				<label class="error"><?= isset($validator->errorMessage['content']['chaine']) ? $validator->errorMessage['content']['message'] : null; ?></label>
			</div>

			<div class="input">
				<input type="checkbox" name="status" value="1" /><label>Voulez-vous directement publier cet article ?</label>
			</div>

			<div class="input">
				<input type="checkbox" name="accueil" value="1" /><label>Voulez-vous afficher cet article sur la page d'accueil ?</label>
			</div>

			<div class="input">
				<input type="submit" value="Envoyer"/>
			</div>
		</form>

		</form>
	</article>
	<!-- Chargement de l'editeur wysiwyng -->
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce.js"></script>
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce_load.js"></script>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>