<?php
	$title = "Connection"; // Définit le titre de la page

	// Chargement du header
	include_once ROOT_TEMPLATE.'header.php';
?>
<article>
		<form method="POST" action="#">
		<fieldset>
			<legend>Permission du compte</legend>
			<div class="input">
				<label>Permission du compte :</label>
				<select name="permission">
					<option value="membre" <?= ($permission == 'membre' ) ? 'selected="selected"' : null; ?> >Membre</option>
					<option value="autheur" <?= ($permission == 'autheur' ) ? 'selected="selected"' : null; ?>>Autheur</option>
					<option value="admin" <?= ($permission == 'admin' ) ? 'selected="selected"' : null; ?>>Admin</option>
				</select>
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