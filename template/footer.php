			</div>
<!-- ----------- Footer du site ---------- -->
			<footer>
				<h2>Suivez-nous sur :</h2>
				<p><img src="<?= URL_TEMPLATE.'img/Logo/facebook.png' ?>" alt="logo_facebook"></p>

				<h2>Informations complémentaires :</h2>
								
				<ul>
					<li><a href="#">Conditions généales d'utilisation</a></li>
					<li><a href="#">Evolution du site</a></li>
					<li><a href="#">Qui sommes-nous ?</a></li>
					<li><a href="#">Nos partenaires</a></li>
				</ul>
						
				<p>© 2014-2015 Le site a été développé par Kevin Joudrier avec l'assistance de Patrick Joudrier et le soutient de Mathieu Vaudano.<a href="http://www.easygiga.com" target="blank"><img src="<?= URL_TEMPLATE.'img/Logo/bannerpartner2.gif' ?>" alt="logo_easygiga"></a></p>
				<p>
					<?php
						// Affiche les session en mode debug
						debugSession();
					?>
				</p>
			</footer>
		<!-- ------------ END --------------------- -->
		</div>
		<!-- ------------ END --------------------- -->

		<!-- Chagrments des fichiers javascripts -->
		<script src="<?= URL_TEMPLATE ?>/js/jquery.js"></script>
		<script src="<?= URL_TEMPLATE ?>/js/ArmaturDesignKJ/pannel.js"></script>
		<script src="<?= URL_TEMPLATE ?>/js/BGR/menu.js"></script>
		<!-- ------------ END ----------------- -->
	</body>
</html>