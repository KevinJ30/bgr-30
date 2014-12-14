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

	// On récupére le menu du site en faisant appelle au model menu
	include_once ROOT_PAGES.'pages/PagesModel.php'; // Permet de l'inclure qu'une seule fois
	include ROOT_PAGES.'menus/MenusModel.php';

	$menuModel = new MenusModel('menus');
	$pagesModel = new PagesModel('pages');

	$menu = $menuModel->admin_getMenus();
?>

<nav>
	<ul id="menu">
		<?php foreach($menu as $v) : ?>
		<li class="bouton">
			<a href=""><?= $v->name; ?></a>
			<ul class="sous-menu">
			<?php $pages = $pagesModel->getPagesMenu($v->id); ?>
			<?php foreach($pages as $value) : ?>
					<a href="<?= URL_PAGES.'pages/index.php?function=view&id='.$value->id;?>"><?= $value->title; ?></a>
			<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>

		<!-- Bouton standart -->
		<li class="bouton">
			<a href="<?= URL_PAGES.'news/index.php'; ?>">Actualités</a>
		</li>

		<li class="bouton">
			<a href="<?= URL_PAGES.'events/index.php'; ?>">Evénement</a>
		</li>

		<?php
			if($connect)
			{
		?>
			<li class="bouton">
				<a href="#">Mon compte</a>
				<ul class="sous-menu">
					<a href="<?= URL_PAGES.'users'.__DS__.'index.php?function=profil&id='.$_SESSION['auth']['id']; ?>">Profil</a>
					<a href="<?= URL_PAGES.'users'.__DS__.'index.php?function=logout&token='.$_SESSION['token']; ?>">Se déconnecter</a>
				</ul>
			</li>
		<?php
				if($_SESSION['auth']['permission'] == 'admin' || $_SESSION['auth']['permission'] == 'autheur')
				{
		?>
					<li class="bouton">
						<a href="<?= URL_PAGES.'admin/index.php'; ?>">Admin</a>
					</li>
		<?php
				}
			}
			else
			{
		?>
			<li class="bouton">
				<a href="<?= URL_PAGES.'users'.__DS__.'index.php?function=login'; ?>">Connectez-vous</a>
				<ul class="sous-menu">
					<a href="<?= URL_PAGES.'users'.__DS__.'index.php?function=register'; ?>">S'inscrire</a>
				</ul>
			</li>
		<?php
			}
		?>
	</ul>
</nav>