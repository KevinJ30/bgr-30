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

	$token = session_generateToken(true);
?>
	<article>
	<table>
		<caption>Liste des comptes</caption>
		<tr>
			<th>Identifiant</th>
			<th>nom</th>
			<th>prenom</th>
			<th>mail</th>
			<th>Permission</th>
			<th>Activer</th>
			<th>Actions</th>
		</tr>
<?php
	foreach($comptes as $v) :
?>
		<tr>
			<td><?= $v->username; ?></td>
			<td><?= $v->nom; ?></td>
			<td><?= $v->prenom; ?></td>
			<td><?= $v->mail; ?></td>
			<td><a href="<?= URL_PAGES.'users/index.php?function=admin_changePermission&id='.$v->id.'&token='.$token; ?>"><?= $v->permission; ?></a></td>
			<td><a href="<?= URL_PAGES.'users/index.php?function=admin_changeStatus&id='.$v->id.'&token='.$token; ?>" onclick="return(confirm('Etes-vous sur de vouloir changer le status du compte?'));"><?= ($v->active == 1) ? 'Activé' : 'désactivé'; ?></a></td>
			<td>
				<p>
					<ul>
						<li><a href="<?= URL_PAGES.'users/index.php?function=admin_edit&id='.$v->id.'&token='.$token; ?>">Editer</a></li>
						<li><a href="<?= URL_PAGES.'users/index.php?function=admin_delete&id='.$v->id.'&token='.$token; ?>" onclick="return(confirm('Etes-vous sur de vouloir supprimer ce compte?'));">Supprimer</a></li>
					</ul>
				</p>
			</td>
		</tr>
<?php		
	endforeach;
?>
	</table>

	<a href="<?= URL_PAGES.'users/index.php?function=admin_add&token='.$token; ?>">Ajouter</a>
	
	</article>
<?php
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>