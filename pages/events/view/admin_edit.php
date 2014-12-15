<?php
	/**
	 * File : pages/events/view/admin_add.php
	 *
	 * Crée par Joudrier Kevin
	 *
	 * Permet d'ajouté un événement
	 **/

	$title = "Edité un événement";

	// charge le header
	include_once ROOT_TEMPLATE.'headerAdmin.php';
?>
	<article>
		<h1>Edité un événement</h1>

		<form action="#" method="POST">
			<div class="input input-row large-5">
				<label>Titre de l'événement :</label>
				<input type="text" name="title" placeholder="Titre de l'événement" value="<?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['chaine'] : $eventExist->title; ?>" />
				<label class="error"><?= isset($validator->errorMessage['title']['chaine']) ? $validator->errorMessage['title']['message'] : null; ?></label>
			</div>

			<div class="input input-row">
				<label>Associer à une categorie :</label>
				<select name="categoriesId" class="large-12">
					<?php 
						foreach ($categories as $value) :
							if($value->id == $eventsExist->category_id)
							{
								echo '<option value="'.$value->id.'" selected="selected">'.$value->name.'</option>';
							}
							else
							{
								echo '<option value="'.$value->id.'">'.$value->name.'</option>';	
							}
					 	endforeach;
					 ?>
					<option value="0">Aucun</option>
				</select>
			</div>
			<div class="clear-both"></div>
			
			<div class="input input-row large-2">
				<label>Date de début :</label>
				<input type="date" name="date_start"  value="<?= isset($validator->errorMessage['date_start']['chaine']) ? $validator->errorMessage['date_start']['chaine'] : $eventExist->date_start; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['date_start']['chaine']) ? $validator->errorMessage['date_start']['message'] : null; ?></label>
			</div>
			<div class="input input-row large-2">
				<label>Heure de début :</label>
				<input type="time" name="heure_start"  value="<?= isset($validator->errorMessage['heure_start']['chaine']) ? $validator->errorMessage['heure_start']['chaine'] : $eventExist->heure_start; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['heure_start']['chaine']) ? $validator->errorMessage['heure_start']['message'] : null; ?></label>
			</div>
			<div class="clear-both"></div>
			<div class="input input-row large-2">
				<label>Date de fin :</label>
				<input type="date" name="date_end"  value="<?= isset($validator->errorMessage['date_end']['chaine']) ? $validator->errorMessage['date_end']['chaine'] : $eventExist->date_end; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['date_end']['chaine']) ? $validator->errorMessage['date_end']['message'] : null; ?></label>
			</div>
			<div class="input input-row large-2">
				<label>Heure de fin :</label>
				<input type="time" name="heure_end"  value="<?= isset($validator->errorMessage['heure_end']['chaine']) ? $validator->errorMessage['heure_end']['chaine'] : $eventExist->heure_end; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['heure_end']['chaine']) ? $validator->errorMessage['heure_end']['message'] : null; ?></label>
			</div>
			<div class="clear-both"></div>
			<div class="input">
				<label>Description :</label>
				<textarea rows="10" cols="50" placeholder="Description" name="description"><?= isset($validator->errorMessage['description']['chaine']) ? $validator->errorMessage['description']['chaine'] : $eventExist->description; ?></textarea>
				<label class="error"><?= isset($validator->errorMessage['description']['chaine']) ? $validator->errorMessage['description']['message'] : null; ?></label>
			</div>
			<div class="input large-4">
				<label>Lieu de l'événement :</label>
				<input type="text" name="lieu" placeholder="Lieu de l'évenement"  value="<?= isset($validator->errorMessage['lieu']['chaine']) ? $validator->errorMessage['lieu']['chaine'] : $eventExist->lieu; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['lieu']['chaine']) ? $validator->errorMessage['lieu']['message'] : null; ?></label>
			</div>
			<div class="input large-4">
				<label>Adresse de l'événement :</label>
				<input type="text" name="adresse" placeholder="Adresse de l'évenement"  value="<?= isset($validator->errorMessage['adresse']['chaine']) ? $validator->errorMessage['adresse']['chaine'] : $eventExist->adresse; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['adresse']['chaine']) ? $validator->errorMessage['adresse']['message'] : null; ?></label>
			</div>
			<div class="input large-4">
				<label>Adresse e-mail à contacter :</label>
				<input type="text" name="mail" placeholder="Adresse e-mail à contacter"  value="<?= isset($validator->errorMessage['mail']['chaine']) ? $validator->errorMessage['mail']['chaine'] : $eventExist->mail; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['mail']['chaine']) ? $validator->errorMessage['mail']['message'] : null; ?></label>
			</div>
			<div class="input large-4">
				<label>Personne à contacter :</label>
				<input type="text" name="contact" placeholder="Personne à contacter"  value="<?= isset($validator->errorMessage['contact']['chaine']) ? $validator->errorMessage['contact']['chaine'] : $eventExist->contact; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['contact']['chaine']) ? $validator->errorMessage['contact']['message'] : null; ?></label>
			</div>
			<div class="input large-4">
				<label>Numéro de téléphone :</label>
				<input type="text" name="phone" placeholder="Numéro de téléphone"  value="<?= isset($validator->errorMessage['phone']['chaine']) ? $validator->errorMessage['phone']['chaine'] : $eventExist->phone; ?>"/>
				<label class="error"><?= isset($validator->errorMessage['phone']['chaine']) ? $validator->errorMessage['phone']['message'] : null; ?></label>
			</div>
			<div class="input">
				<input type="checkbox" name="actif" value="1" <?= $eventExist->actif == null ? null : 'checked="checked"' ?> /><label>Voulez-vous directement publier cet événement ?</label>
			</div>
			<div class="input">
				<input type="submit" value="Envoyer"/>
			</div>
		</form>

	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>