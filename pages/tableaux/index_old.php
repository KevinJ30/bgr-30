<?php
	/**
	 * File : pages/menus/index.php.php
	 *
	 * Crées par Joudrier Kevin
	 *
	 * Permet de gérer le chargement des fonctions du script
	 **/

	// Charge le controller
	require '../../includes/includes.php';
    require ROOT.'elements/agenda.php';
	include_once ROOT_TEMPLATE.'header.php';
        
        // Création du tableaux Contenant le mois
        /*$calendar = array();
        $month = 11;
        $lastMonth = ($month - 1);
        $years = 2014;
        
        $debut = getNumberDay(01, $month, $years);
        $lastDayMonth = getDayMonth($lastMonth, $years);
        $dayMonth = getDayMonth($month, $years);
        
        
        // Si $debut est suppèrieure ou inférieure à 1 alors sa veut dire que le mois commence en cours de mois
        if($debut < 1 || $debut > 1)
        {
            $debut = $debut - 1;
            // Si $debut est inférieure a 1 sa veut dire le mois commence un dimanche
            if($debut < 1)
            {
                $calendar[0][5]['numero'] = null;
                for($i = 4; $i >= 0; $i--)
                {
                    $lastDayMonth = null;
                    $calendar[0][$i]['numero'] = $lastDayMonth;
                }
            }
            else
            {
                $calendar[0][$debut - 1]['numero'] = null;
                for($i = $debut - 2; $i >= 0; $i--)
                {
                    $lastDayMonth = null;
                    $calendar[0][$i]['numero'] = $lastDayMonth;
                }
            }
           
            // On inverse le sens du tableaux
            $calendar[0] = array_reverse($calendar[0], true);
 
           $compteur = 0;
           for($i = $debut; $i < 7; $i++)
           {
               $compteur = $compteur+1;
               $calendar[0][$i]['numero'] = $compteur;
           }
        }
        else
        {
            $compteur = 0;
            // Si Le mois commence le lundi alors on rempli
            for($i = 0; $i < 7; $i++)
            {
                $compteur = $compteur + 1;
                $calendar[0][$i]['numero'] = $compteur;
            }
        }*/
        
        /**
         * On rempli le reste du tableaux
         **/
        
        /*$lastValue = $calendar[0][6]['numero'];
      
        for($i = 1; $i <= 5; $i++)
        {
            for($a = 0; $a < 7; $a++)
            {
                 
                if($lastValue == $dayMonth)
                {
                    $calendar[$i][$a]['numero'] = null;
                }
                else
                {
                    $lastValue = $lastValue + 1;
                    $calendar[$i][$a]['numero'] = $lastValue;
                }
            }
        }*/
        
        $calendrier = generateCalendar(11, 2014);
?>
	<div class="row-agenda">
		<div id="left-bar">
			<div class="content-left_bar">
                <div class="title">Calendrier</div>
				<?php drawCalendar($calendrier); ?>
			</div>
                 
			<div class="content-left_bar no-marge">
				<div class="title">Systeme category</div>
				<div class="content">
					<form action="#" method="POST">
						<div class="input input-row large-6">
							<select name="mois">
								<option value="essai1">novembre</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
							</select>
						</div>
						<div class="input input-row large-5">
							<select name="mois">
								<option value="essai1">2014</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
							</select>
						</div>
						<div class="input">
							<select name="mois">
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
								<option value="essai1">essai1</option>
							</select>
						</div>
						<div class="input">
							<input type="submit" value="Afficher" />
						</div>
					</form>
				</div>
			</div>
			<div class="content-left_bar no-marge">
				<div class="title">Menu</div>
				<div class="content">
					<ul>
						<li><a href="#">Link 1</a></li>
						<li><a href="#">Link 2</a></li>
						<li><a href="#">Link 3</a></li>
						<li><a href="#">Link 4</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="content-agenda">
			<div class="block-agenda">
				<p>Du <strong>16/11/2014</strong> à <strong>19:00</strong> au <strong>17:11</strong> à <strong>08:00</strong></p>
				<p><strong>Atelier :</strong> essai</p>
				<p>Voici l'event</p>
				<p><strong>Lieu :</strong> bagnols</p>
				<p><strong>Contact :</strong> BGR30.com</p>
				<p><strong>En savoir plus :</strong> Essai de l'agenda</p>
			</div>
		</div>
	</div>
	
		<!-- On reset le float -->
<?php 
	include_once ROOT_TEMPLATE.'footer.php';
?>