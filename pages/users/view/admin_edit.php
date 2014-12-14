<?php
	/**
	 * File : pages/users/view/profil.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Page du profil
	 **/

	// Titre de la page
	$title = 'Profil';

	// Chargement du header
	include_once ROOT_TEMPLATE.'headerAdmin.php';
?>
	<article>
			<form method="POST" action="#">
				<fieldset>
					<legend>Information du compte</legend>
					
					<div class="input">
						<label>Identifiant : </label>
						<input name="username" type="text" placeholder="identifiant" value="<?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['chaine'] : $username; ?>" />
						<label class="error"><?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['message'] : null; ?></label>
					</div>

					<div class="input">
						<label>Mot de passe : </label>
						<input name="password" type="password" placeholder="mot de passe"/>
						<label class="error"><?= isset($validator->errorMessage['password']['chaine']) ? $validator->errorMessage['password']['message'] : null; ?></label>
					</div>	
				</fieldset>

				<fieldset>
					<legend>Information complémentaire :</legend>

					<div class="input">
						<label>Nom :</label>
						<input name="nom" type="text" placeholder="Nom"  value="<?= isset($validator->errorMessage['nom']['chaine']) ? $validator->errorMessage['nom']['chaine'] : $nom; ?>"/>
						<label class="error"><?= isset($validator->errorMessage['nom']['chaine']) ? $validator->errorMessage['nom']['message'] : null; ?></label>
					</div>

					<div class="input">
						<label>Prenom :</label>
						<input name="prenom" type="text" placeholder="Prenom" value="<?= isset($validator->errorMessage['prenom']['chaine']) ? $validator->errorMessage['prenom']['chaine'] : $prenom; ?>"/>
						<label class="error"><?= isset($validator->errorMessage['prenom']['chaine']) ? $validator->errorMessage['prenom']['message'] : null; ?></label>
					</div>

					<div class="input">
						<input type="checkbox" name="active" value="1" <?= ($active == 1) ? 'checked="checked"' : null; ?> /><label>Activer le compte?</label>
					</div>

					<div class="input">
						<label>Type de compte :</label>
						<select name="permission">
							<option value="membre" <?= ($permission == 'membre' ) ? 'selected="selected"' : null; ?> >Membre</option>
							<option value="autheur" <?= ($permission == 'autheur' ) ? 'selected="selected"' : null; ?>>Autheur</option>
							<option value="admin" <?= ($permission == 'admin' ) ? 'selected="selected"' : null; ?>>Admin</option>
						</select>
					</div>
				</fieldset>
				<div class="input">
					<input type="submit" value="Modifier le compte">
				</div>
			</form>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>