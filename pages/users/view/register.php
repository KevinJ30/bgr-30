<?php
	$title = "Inscription"; // Définit le titre de la page

	// Chargement du header
	include_once ROOT_TEMPLATE.'header.php';
?>
<div class="pannel-box warning">
	<p>Vous devez faire partie du club pour vous inscrire sur le site.<br />Vous devez renseigner tout les champs commençant par un *.</p>
</div>

<fieldset>
	<legend>Inscription :</legend>

	<form method="POST" action="#">
	<fieldset>
		<legend>Identifiant de connection</legend>

		<div class="input">
			<label>*Identifiant : </label>
			<input type="text" name="username" placeholder="Identifiant" value="<?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>*Mot de passe : <small>Votre mot de passe doit contenir au moin une majuscule et avoir 8 caractères minimum.</small></label>
			<input type="password" name="password" placeholder="Mot de passe" value="<?= isset($validator->errorMessage['password']['chaine']) ? $validator->errorMessage['password']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['password']['message']) ? $validator->errorMessage['password']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>*Confirmation du mot de passe :</label>
			<input type="password" name="check_password" placeholder="Confirmation du mot de passe" value="<?= isset($validator->errorMessage['check_password']['chaine']) ? $validator->errorMessage['check_password']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['check_password']['message']) ? $validator->errorMessage['check_password']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>*E-mail :</label>
			<input type="e-mail" name="mail" placeholder="E-mail" value="<?= isset($validator->errorMessage['mail']['chaine']) ? $validator->errorMessage['mail']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['mail']['message']) ? $validator->errorMessage['mail']['message'] : null; ?></label>
		</div>
	</fieldset>

	<fieldset>
		<legend>Informations complémentaires</legend>

		<div class="input">
			<label>*Nom :</label>
			<input type="text" name="nom" placeholder="Nom" value="<?= isset($validator->errorMessage['nom']['chaine']) ? $validator->errorMessage['nom']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['nom']['message']) ? $validator->errorMessage['nom']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>*Prenom :</label>
			<input type="text" name="prenom" placeholder="Prenom" value="<?= isset($validator->errorMessage['prenom']['chaine']) ? $validator->errorMessage['prenom']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['prenom']['message']) ? $validator->errorMessage['prenom']['message'] : null; ?></label>
		</div>

		<div class="input">
			<label>*N° de licence FFBA : </label>
			<input type="text" name="licence" placeholder="N° de licence" value="<?= isset($validator->errorMessage['licence']['chaine']) ? $validator->errorMessage['licence']['chaine'] : null; ?>">
			<label class="error"><?= isset($validator->errorMessage['licence']['message']) ? $validator->errorMessage['licence']['message'] : null; ?></label>
		</div>
	</fieldset>

	<div class="input">
		<input type="submit" value="Valider l'inscription">
	</div>
	</form>
</fieldset>
<?php
	include_once ROOT_TEMPLATE.'footer.php';
?>