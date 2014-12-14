<?php
	/**
	 * File : pages/pages/view/index.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Affiche la page d'accueil du site
	 **/

	$title = "Actualités";

	// charge le header
	include_once ROOT_TEMPLATE.'header.php';
?>
	<article>
		<?php 
			if(!$news)
			{
		?>
				<div class="pannel-box warning">
					<p>Aucune actualité présente sur le site.</p>
				</div>
		<?php 
			}
		?>
	
		<?php foreach($news as $v) : ?>
			<h1><?= $v->title ?><small>Créé le : <?= $v->created ?> par : <?= $v->users_username; ?></small></h1>
			<p><?= $v->content; ?></p>
		<?php endforeach; ?>
		<!-- Affichage du paginator -->
		<div id="paginator">
			<?php if($page > 0) : ?>
				<a href="<?= URL_PAGES.'news/index.php?function=index&page='.($page-1); ?>" class="button"><button class="site blue"><<</button></a>
			<?php endif; ?>
			
			<?php
				for($count = 0; $count < $nbPages; $count++) :
					$link = '<a href="'.URL_PAGES.'news/index.php?function=index&page='.$count.'" class="button"><button class="site blue ';
					if($page == $count)
					{
						$link .= 'selected';
					}
					$link .= '">';
					$link .= $count + 1;
					$link .= '</button></a> ';
					
					echo $link;
				endfor;
			?>
			<?php if($page + 1 < $nbPages) : ?>
				<a href="<?= URL_PAGES.'news/index.php?function=index&page='.($page+1); ?>" class="button"><button class="site blue">>></button></a>
			<?php endif; ?>
		</div>
	</article>
<?php 
	// Chargement du footer
	include_once ROOT_TEMPLATE.'footer.php';
?>