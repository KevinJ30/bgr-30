<?php

/**
 * File : includes/date.php
 *
 * Crées par Joudrier Kevin
 *
 * Permet la gestion des dates
 * 
 * Toutes les variable de ceux fichier sont déclarer en global car inoffensif sur le systèmes
 **/

/**
 * Contient la liste des mois
 **/

// Tableaux Contenant les mois de l'année en frençais
$GLOBALS["formatFrMois"] = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
// Tableaux Contenant les Jour de la semaine en frençais
$GLOBALS["formatFrJours"] = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

// Contient la date du jour
$GLOBALS["date"] = array(
        "day" => date("d"),
        "month" => date("m"),
        "years" => date("Y"),
        "complet" => date("d-m-Y")
);

/**
 * getDayMonth
 * 
 * Si aucun paramètre n'est spécifier dans la fonction alors la fonction renvoie le nombre de jours dans le mois courant
 * 
 * @param : $month : le mois pour lequel on cherche le nombre de jours sous forme de nombre, par défaut la valeur est égal au mois courant
 * @param : $years : Définit l'année sur laqu'elle on recherche, par défaut la valeur est égal a l'année courante
 * @return Retourne le nombre de jour dans le mois
 * @exemple : getDayMonth(01, 2014) retournera 31 jours dans le mois
 **/

function getDayMonth($month = null, $years = null)
{ 
    // Si le mois n'est pas définit il vaut le mois courant
    if(!isset($month))
    {
        $month = date("m");
    }
    else if($month <= 0)
    {
        $month = 1;
    }
    
    // Si l'années n'est pas définit alors l'année est egal a l'année crouante
    if(!isset($years))
    {
        $years = date("Y");
    }
    else if($years <= 0)
    {
        $years = 1;
    }
    
    $timestamp = mktime(0, 0, 0, $month, 01, $years);
    return date("t", $timestamp);
}

/**
 * getNumberDay
 * 
 * Si aucun paramètre n'est spécifier retourne le numéro du jour courant
 * 
 * @param : $day Le jour pour lequel on cherche le numéro de la semaine
 * @param : $month Le mois pour lequel on cherche le numéro du jour de la semaine
 * @param : $years L'année pour lequel on cherche le numéro du jour de la semaine
 * @return : le numéro du jour de la semaine
 **/
function getNumberDay($day = null, $month = null, $years = null)
{
    // Si le jours n'est pas définit alors le jours utilisé est le jour courant
    if(!$day)
    {
        $day = date("d");
    }
    
    if(!$month)
    {
        $month = date("m");
    }
    
    if(!$years)
    {
        $years = date("Y");
    }
    
    $timestamp = mktime(0, 0, 0, $month, $day, $years);
    
    return date("w", $timestamp);
}

/**
 *  generateCalendar
 * 
 * Si aucun paramétre n'est passé on retourne le calendrier sur le mois courant et l'année courante
 * 
 * (Attention Le calendrier se charge en partant du premier du mois)
 * 
 * @param : $month Le mois sur lequel on veut générer le calendrier
 * @param : $years Renseigne l'année sur laquel on veut générer le clendrier 
 * @return : retourne un tableau contenant le calendrier
 **/

function generateCalendar($month, $years)
{
    $lastMonth = $month - 1; // Contient le mois d'avant
    $debut = getNumberDay(01, $month, $years); // Permet de déterminé numéro du jour sur le qu'elle on se trouve
    $lastDayMonth = getDayMonth($lastMonth, $years); // Stock le nombre de jour du mois dernier
    $dayMonth = getDayMonth($month, $years); // Stock le nombre de jour du mois
    
    $i = null; // Increment
    $a = null; // Increment
    
    $compteur = null; // Permet de calculer le jour que l'on doit rentré dans le tableaux
    
    $calendar = array();     // Tableaux contenant le calendrier du mois

    // On charge le mois et l'année dans le tableaux
    $calendar['month'] = $month;
    $calendar['years'] = $years;
    
    // Si $debut est supèrieure ou inférieure à 1 alors sa veut dire que le mois commence en cours de semaine
    if($debut < 1 || $debut > 1)
    {
        $debut = $debut - 1;

        // Si $debut est inférieure à 1 sa veut dire que le mois commence un dimanche
        if($debut < 1)
        {  
            for($i = 0; $i <= 5; $i++)
            {
            
                $lastDayMonth = null;
                $calendar[0][$i]['numero'] = $lastDayMonth;
            }
            $calendar[0][6]['numero'] = 1;
        }
        else
        {
            $calendar[0][$debut - 1]['numero'] = null;
            for($i = $debut - 2; $i >= 0; $i--)
            {
                $lastDayMonth = null;
                $calendar[0][$i]['numero'] = $lastDayMonth;
            }

            // On inverse le sens du tableaux
            $calendar[0] = array_reverse($calendar[0], true);

             $compteur = 0;
        
            for($i = $debut; $i < 7; $i++)
            {
                $compteur = $compteur + 1;
                $calendar[0][$i]['numero'] = $compteur;
            }
        }  
    }
    else
    {
        $compteur = 0;
        
        // Si le mois commence un lundi alors on rempli
        for($i = 0; $i < 7; $i++)
        {
            $compteur = $compteur + 1;
            $calendar[0][$i]['numero'] = $compteur;
        }
    }
    
    // On remplit les ligne qu'il nous pour le calendrier
    $lastValue = $calendar[0][6]['numero']; // On récupére la dernier valeur rentré dans le tableaux
    
    for($i = 1; $i <= 5; $i++)
    {
        for($a = 0; $a < 7; $a++)
        {
            
            // Si on a dépasser le nombre maximun de jour dans le mois on rentre les valeur à null
            if($lastValue == $dayMonth)
            {
                $calendar[$i][$a]['numero'] = null;
            }
            else
            {
               // Sinon on remplit le tableaux normalement
                $lastValue = $lastValue + 1;
                $calendar[$i][$a]['numero'] = $lastValue;
            }
            
        }
    }
    // On retourn le tableau contenant le calendrier du mois
    return $calendar;
}








