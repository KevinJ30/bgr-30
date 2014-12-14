<?php
	/**
	 * File : pages/news/view/admin_add.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet d'ajouter une news sur le site
	 **/

	// Titre de la page
	$title = 'Evénement';

	// Chargement du header
	include_once ROOT_TEMPLATE.'header.php';
?>
	<div class="row-agenda">
		<div id="left-bar">
			<div class="content-left_bar">
				<div class="title">Calendrier</div>
				<?php drawCalendar($calendrier); ?>
			</div>

			<div class="content-left_bar">
				<div class="title">Filtre</div>
				<div class="content">
					<form action="#" method="POST">
						<div class="input input-row large-6">
							<label>Mois :</label>
							<select name="month">
								<?php foreach($GLOBALS['formatFrMois'] as $k=>$v) : ?>
									<?php if($searchDate['month'] == $k + 1) : ?>
										<option value="<?= $k + 1; ?>" selected="selected"><?= $v; ?></option>
									<?php else : ?>
										<option value="<?= $k + 1; ?>"><?= $v; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="input input-row large-5">
							<label>Années : </label>
							<select name="years">
								<?php
									$years = $GLOBALS['date']['years'] - 3;
									for($i = 0; $i < 2; $i++)
									{
										$years++;
										if($searchDate['years'] == $years)
										{
											echo '<option value="'.$years.'" selected="selected">'.$years.'</option>';
										}
										else
										{
											echo '<option value="'.$years.'">'.$years.'</option>';
										}
									}

									$years = $GLOBALS['date']['years'];

									if($searchDate['years'] == $years)
									{
										echo '<option value="'.$years.'" selected="selected">'.$years.'</option>';
									}
									else
									{
										echo '<option value="'.$years.'">'.$years.'</option>';	
									}
									
									for($i = 0; $i < 3; $i++)
									{
										$years++;
										if($searchDate['years'] == $years)
										{
											echo '<option value="'.$years.'" selected="selected">'.$years.'</option>';		
										}
										else
										{
											echo '<option value="'.$years.'">'.$years.'</option>';
										}
									}
								?>
							</select>
						</div>
						<div class="input">
							<label>Catégories : </label>
							<select name="categories">
								<?php foreach($categories as $v) : ?>
									<?php
										if(!empty($_POST))
										{
											if($_POST['categories'] == $v->id)
											{
												echo '<option value="'.$v->id.'" selected="selected">'.$v->name.'</option>';
											}
											else
											{
												echo '<option value="'.$v->id.'">'.$v->name.'</option>';
											}
										}
										else
										{
											if($v->default == 1)
											{
												echo '<option value="'.$v->id.'" selected="selected">'.$v->name.'</option>';
											}
											else
											{
												echo '<option value="'.$v->id.'">'.$v->name.'</option>';	
											}
										}
									?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="input">
							<input type="submit" value="Afficher" />
						</div>					
					</form>
				</div>
			</div>
		</div>

		<div id="content-agenda">
			<?php if(empty($events)) : ?>
				<div class="block-agenda">
					<p><strong>Aucun évément de prévue.</strong></p>
				</div>
			<?php endif; ?>

			<?php foreach($events as $v) : ?>
				<div class="block-agenda">
					<p>Du <strong><?= $v->date_start; ?></strong> à <strong><?= $v->heure_start; ?></strong> au <strong><?= $v->date_end; ?></strong> à <strong><?= $v->heure_end; ?></strong></p>
					<p><strong>Categorie :</strong> essai</p>
					<p><?= $v->description; ?></p>
					<p><strong>Lieu :</strong> <?= $v->lieu; ?></p>
					<p><strong>Contact :</strong> <?= $v->mail; ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>



	<!-- Chargement de l'editeur wysiwyng -->
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/tinymce.js"></script>
	<script type="text/javascript" src="<?= URL_TEMPLATE ?>/js/tinymce/js/tinymce/newsTinymce_load.js"></script>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>