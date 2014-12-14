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
include_once ROOT_TEMPLATE . 'headerAdmin.php';
?>
<article>
	<h1>Editer une page sur le site</h1>

	<form action="#" method="POST">
		<div class="input input-row large-5">
			<label>Titre de la page :</label> <input type="text" name="title"
				placeholder="Titre de la page"
				value="<?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['chaine'] : $page->title; ?>" />
			<label class="error"><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['message'] : null; ?></label>
		</div>

		<div class="input input-row">
			<label>Associer a un menu :</label> <select name="menu"
				class="large-12">
					<?php foreach ($menus as $menu) : ?>
						<?php
							if($page->menu_id > 0 && $menu->id == $page->menu_id)
							{
								echo '<option selected="selected" value="'.$menu->id.'">'.$menu->name.'</option>';
							}
							else
							{
								echo '<option value="'.$menu->id.'">'.$menu->name.'</option>';
							}
						?>
					<?php 
						endforeach; 
						if($page->menu_id <= 0)
						{
							echo '<option value="0" selected="selected">Aucun</option>';	
						}
						else
						{
							echo '<option value="0">Aucun</option>';	
						}
					?>
					
			</select>
		</div>

		<div class="clear-both"></div>

		<div class="input">
			<textarea name="content"
				placeholder="Insérer le contenu de votre page."><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['content']['chaine'] : $page->content; ?></textarea>
			<label class="error"><?= isset($validator->errorMessage['content']['chaine']) ? $validator->errorMessage['content']['message'] : null; ?></label>
		</div>

		<div class="input">
			<input type="checkbox" name="status" value="1"
				<?= $page->status != 0 ? 'checked="checked"' : null; ?> /><label>Voulez-vous
				mettre directement publier cet article ?</label>
		</div>

		<div class="input">
			<input type="checkbox" name="accueil" value="1"
				<?= $page->accueil != 0 ? 'checked="checked"' : null; ?> /><label>Voulez-vous
				afficher cet article sur la page d'accueil ?</label>
		</div>

		<div class="input">
			<input type="submit" value="Envoyer" />
		</div>
	</form>
</article>
<!-- Chargement de l'editeur wysiwyng -->
<script type="text/javascript"
	src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce.js"></script>
<script type="text/javascript"
	src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce_load.js"></script>
<?php
// Chargement du footer
include_once ROOT_TEMPLATE . 'footer.php';
?>