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
	include_once ROOT_TEMPLATE.'header.php';
?>
	<article>
		<h1>Profil</h1>
		<fieldset>
			<legend>Information du compte</legend>
			<p>Identifiant : <strong><?= $user->username; ?></strong></p>
			<p>Adresse e-mail : <strong><?= $user->mail; ?></strong></p>
			<p>status  : <strong><?= $user->permission; ?></strong></p>
		</fieldset>

		<h1>Modifier mon compte</h1>
		<p>
			<div class="row large-10">
				<h3>Changer mon identifiant</h3>
				
				<form method="POST" action="#">
					<div class="input">
						<label>Identifiant :</label>
						<input type="text" name="username" placeholder="Identifiant" value="<?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['chaine'] : $user->username; ?>">
						<label class="error"><?= isset($validator->errorMessage['username']['chaine']) ? $validator->errorMessage['username']['message'] : null; ?></label> 
					</div>
					<div class="input">
						<input type="submit" value="changer">
					</div>
				</form>
				<h3>Changer mon adresse e-mail</h3>
				<form method="POST" action="#">
					<div class="input">
						<label>Adresse e-mail :</label>
						<input type="text" name="mail" placeholder="E-mail" value="<?= isset($validator->errorMessage['mail']['chaine']) ? $validator->errorMessage['mail']['chaine'] : $user->mail; ?>">
						<label class="error"><?= isset($validator->errorMessage['mail']['chaine']) ? $validator->errorMessage['mail']['message'] : null; ?></label>
					</div>
					<div class="input">
						<input type="submit" value="changer">
					</div>
				</form>
				
				<h3>Changer mon mot de passe</h3>
				<form method="POST" action="#">
					<div class="input">
						<label>Mot de passe actuel :</label>
						<input type="password" name="actuPassword" placeholder="Mot de passe actuel"  value="<?= isset($validator->errorMessage['actuPassword']['chaine']) ? $validator->errorMessage['actuPassword']['chaine'] : null?>">
						<label class="error"><?= isset($validator->errorMessage['actuPassword']['chaine']) ? $validator->errorMessage['actuPassword']['message'] : null; ?></label>
					</div>
					<div class="input">
						<label>Nouveau mot de passe :</label>
						<input type="password" name="password" placeholder="Nouveau mot de passe">
						<label class="error"><?= isset($validator->errorMessage['password']['chaine']) ? $validator->errorMessage['password']['message'] : null; ?></label>
					</div>
					<div class="input">
						<label>Confirmation du mot de passe :</label>
						<input type="password" name="check-password" placeholder="Confirmation mot de passe">
						<label class="error"><?= isset($validator->errorMessage['check-password']['chaine']) ? $validator->errorMessage['check-password']['message'] : null; ?></label>
					</div>
					<div class="input">
						<input type="submit" value="changer">
					</div>
				</form>
			</div>
		</p>
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>