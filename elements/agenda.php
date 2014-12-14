<?php
/**
 * affiche le calendrier en fonction du mois selectionné 
 **/

/**
 * 
 * drawCalendar
 * 
 * Affiche le calendrier
 * 
 * @param $calendar Contient le tableau du calendrier
 **/
function drawCalendar($calendar)
{
    $EventsModel = new EventsModel('events');
    $events = $EventsModel->eventsCalendar($calendar['month'], $calendar['years']);

    $i = null; // Increment
    $a = null; // Increment
    
    $content = '<table id="calendrier">
            <tr>
                <th>Lu</th>
                <th>Ma</th>
                <th>Me</th>
                <th>Je</th>
                <th>Ve</th>
                <th>Sa</th>
                <th>Di</th>   
            </tr>';
    
    for($i = 0; $i <= 5; $i++)
    {
        $content .= '<tr>';
        for($a = 0; $a < 7; $a++)
        {
            $date = $calendar['years'].'-'.$calendar['month'].'-'.$calendar[$i][$a]['numero'];
            //$events = $EventsModel->eventsExist($date);

            // $content .= '<td class="selected evenement">'.$calendar[$i][$a]['numero'].'</td>';
            // $content .= '<td>'.$calendar[$i][$a]['numero'].'</td>';
            // $content .= '<td class="selected">'.$calendar[$i][$a]['numero'].'</td>';
            // $content .= '<td class="evenement">'.$calendar[$i][$a]['numero'].'</td>';

            $exist = null;

            if($calendar[$i][$a]['numero'] == $GLOBALS['date']['day'] && $calendar['month'] == $GLOBALS['date']['month'] && $calendar['years'] == $GLOBALS['date']['years'])
            {
                foreach($events as $v)
                {
                    if($calendar[$i][$a]['numero'] == $v->day)
                    {
                        $exist = array('id' => $v->id);
                    }
                }

                if($exist)
                {
                    $content .= '<td class="selected evenement">'.$calendar[$i][$a]['numero'].'</td>';
                }
                else
                {
                    $content .= '<td class="selected">'.$calendar[$i][$a]['numero'].'</td>';
                }
            }
            else
            {
                $exist = null;
                foreach($events as $v)
                {
                    if($calendar[$i][$a]['numero'] == $v->day)
                    {
                        $exist = array('id' => $v->id);
                    }
                }

                if($exist)
                {
                    $content .= '<td class="evenement">'.$calendar[$i][$a]['numero'].'</td>';
                }
                else
                {
                    $content .= '<td>'.$calendar[$i][$a]['numero'].'</td>';   
                }
            }

        }
        $content .= '</tr>';
    }
    $content .= '</table>';

    echo $content;
}