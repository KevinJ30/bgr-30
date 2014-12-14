<?php
	// Retourne si on est connecté ou nom
	if(isset($_SESSION['auth']) && !empty($_SESSION['auth']))
	{
		session_generateToken(true);
		$connect = true;
	}
	else
	{
		$connect = false;
	}
?>


<nav>
	<ul id="menu">
		<?php
			if($connect)
			{
				if($_SESSION['auth']['permission'] == 'admin' || $_SESSION['auth']['permission'] == 'autheur')
				{
		?>
					<li class="bouton">
						<a href="<?= URL_ROOT.'index.php'; ?>">Revenir sur le site</a>
					</li>

					<li class="bouton">
						<a href="<?= URL_PAGES."menus/index.php" ?>">Menu</a>
					</li>

					<li class="bouton">
						<a href="<?= URL_PAGES."pages/index.php?function=admin_index" ?>">Pages</a>
						<ul class="sous-menu">
							<a href="<?= URL_PAGES."pages/index.php?function=admin_create&token=".$_SESSION['token']; ?>">Ajouter une page</a>
						</ul>
					</li>

					<li class="bouton">
						<a href="<?= URL_PAGES.'news/index.php?function=admin_index'; ?>">Actualités</a>
						<ul class="sous-menu">
							<a href="<?= URL_PAGES.'news/index.php?function=admin_index'; ?>">Liste des actualité</a>
							<a href="<?= URL_PAGES.'news/index.php?function=admin_add&token='.$_SESSION['token']; ?>">Ajouter une actualité</a>
						</ul>
					</li>
                                        
                        <li class="bouton">
							<a href="<?= URL_PAGES.'events/index.php?function=admin_index'; ?>">Evenement</a>
						<ul class="sous-menu">
							<a href="<?= URL_PAGES.'events_categories/index.php?function=admin_index'; ?>">Liste des categories</a>
							<a href="<?= URL_PAGES.'events_categories/index.php?function=admin_add&token='.$_SESSION['token']; ?>">Ajouter une categorie</a>
							<a href="<?= URL_PAGES.'events/index.php?function=admin_index'; ?>">Liste des événements</a>
						</ul>
					</li>
		<?php
					if($_SESSION['auth']['permission'] == 'admin')
					{
		?>
					<li class="bouton">
						<a href="#">Comptes Utilisateur</a>
						<ul class="sous-menu">
							<a href="<?= URL_PAGES.__DS__.'users/index.php?function=admin_list'; ?>">Liste des comptes</a>
							<a href="<?= URL_PAGES.__DS__.'users/index.php?function=admin_add&token='.$_SESSION['token']; ?>">Ajouter un compte</a>
						</ul>
					</li>
		<?php
					}
				}
			}
		?>
	</ul>
</nav>