<?php
	$title = "Connection"; // Définit le titre de la page

	// Chargement du header
	include_once ROOT_TEMPLATE.'header.php';
?>
<fieldset>
	<legend>Connection :</legend>

	<form method="POST" action="#">
		<div class="input">
			<label>Identifiant : </label>
			<input type="text" name="username" placeholder="Identifiant" value="<?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['username']['message']) ? $validator->errorMessage['username']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>Mot de passe : </label>
			<input type="password" name="password" placeholder="Mot de passe" value="<?= isset($validator->errorMessage['password']['chaine']) ? $validator->errorMessage['password']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['password']['message']) ? $validator->errorMessage['password']['message'] : null; ?></label>
		</div>

		<div class="input">
			<input type="submit" value="Se connecter">
		</div>
	</form>
</fieldset>

<fieldset>
	<legend>Pas Encore de compte ?</legend>
	<a href="<?= URL_PAGES.'users/index.php?function=register' ?>">Inscrivez-vous</a>
</fieldset>

<fieldset>
	<legend>Problèmes de connection ?</legend>
	<p><a href="#">Identifiant oublier ?</a></p>
	<p><a href="#">Mot de passe oublier ?</a></p>
</fieldset>
<?php
	include_once ROOT_TEMPLATE.'footer.php';
?>