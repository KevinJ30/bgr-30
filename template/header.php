<!--
  -- File : app/View/Layouts/default.ctp 					  --
  -- ------													  --
  -- Crée par Kevin Joudrier pour le Badminton Gard Rhodanien --
  --														  --
  -- Description : Contient le template général du site 	  --
  -- Design : Utilisation de l'outil "ArmaturDesignKJ"		  -->


<!DOCTYPE html>
<html>
	<head>
		<title><?= (isset($title)) ? $title : 'BGR-30' ?></title>
		<meta charset="utf-8">
		
		<!-- Permet la compatibilité des nouvelles balises sur les ancien navigateur -->
		<!--[if lt IE 9]>
        	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- END -->

        <!-- -------- Chargements des fichier css -------- -->
        <link rel="stylesheet" href="<?= URL_TEMPLATE ?>/css/BGR/ArmaturDesignKJ/ArmaturDesignKJ.css">
   		<link rel="stylesheet" href="<?= URL_TEMPLATE ?>/css/BGR/design.css">
        <!-- -------------- END --------- -->
	</head>
	<body>
		<header>
		<!-- inclut dans le css -->
		</header>

		<?php
			// On affiche les message flash si il y en a
			session_drawFlash();
		?>

		<!-- ----------- Contenu du site ---------- -->
		<div id="main">
			<?php
				// On charge le menu du site
				include(ROOT_TEMPLATE.'menu.php');
			?>
			<div id="content">
			

