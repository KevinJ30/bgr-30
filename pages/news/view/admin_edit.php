<?php
	/**
	 * File : pages/news/view/admin_add.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet d'ajouter une news sur le site
	 **/

	// Titre de la page
	$title = 'Ajouter une actualité';

	// Chargement du header
	include_once ROOT_TEMPLATE.'headerAdmin.php';
?>
	<article>
		<form method="POST" action="#">
			<fieldset>
				<legend>Ajouter une actualité</legend>
				<div class="input">
					<label>Titre de l'actualité :</label>
					<input type="text" name="title" value="<?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['chaine'] : $news->title; ?>">
					<label class="error"><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['message'] : null; ?></label>
				</div>
				
				<div class="input">
					<label>Contenu :</label>
					<textarea name="content" placeholder="Insérer le contenu de votre article."><?= isset($validator->errorMessage['content']['chaine']) ? $validator->errorMessage['content']['chaine'] : $news->content; ?></textarea>
					<label class="error"><?= isset($validator->errorMessage['content']['chaine']) ? $validator->errorMessage['content']['message'] : null; ?></label>
				</div>
				
				<div class="input">
					<input type="checkbox" name="status" value="1" <?= $news->status != 0 ? 'checked="checked"' : null; ?>/><label>Voulez-vous directement publier cet actualité ?</label>
				</div>
			</fieldset>
			
			<div class="input">
				<input type="submit" value="Editer">
			</div>
		</form>
	</article>
	<!-- Chargement de l'editeur wysiwyng -->
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce.js"></script>
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/newsTinymce_load.js"></script>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>