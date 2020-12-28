<?php

/**
 * Class to represent the tasks belonging to a Todo and create by a User.
 */

namespace App\Model\Utils;

class Calendar
{

    private $day;
    private $first_day;
    private $first_day_index;
    private $last_day;
    private $dayArray;

    function __construct($timestamp = null)
    {
        if($timestamp === null){
            $this->day = getdate();
        }else{
            $this->day = getdate(intval($timestamp)
        );
        }
        $this->first_day = intval(date("d", mktime(0, 0, 0, $this->day["mon"], 1, $this->day["year"])));
        $this->first_day_index = intval(date("w", mktime(0, 0, 0, $this->day["mon"], 1, $this->day["year"])) - 1); // -1 car notre tableau commence à 0.
        //Le Mardi = 2 donc dans notre tableau == 1.
        $this->last_day = intval(date("d", mktime(0, 0, 0, $this->day["mon"] + 1, 0, $this->day["year"])));
        $this->dayArray = array();

        $this->dayBefore();
        $this->dayCurrent();
    }

    /**
     * Fonction concernant les jours antérieur au mois courant.
     * first_day_index étant le nombre de jour antérieur.
     */
    private function dayBefore()
    {
        for ($i = 0; $i < $this->first_day_index; $i++) {
            $this->dayArray[$i] = "ab";
        }
    }

    /**
     * Fonction concernant les jours du mois courant.
     * On commence après les jours antérieur => $i = $first_day_index.
     * Donc on va jusqu'a nbJourMois + nbJourAntérieur.
     */
    private function dayCurrent()
    {
        $compteur_jour = 0; //S'incrémente jusqu'au nombre de jour max du mois. Représente la valeur des différents jour.
        for ($i = $this->first_day_index; $i < $this->last_day + $this->first_day_index; $i++) {
            $compteur_jour++;
            $this->dayArray[$i] = $compteur_jour;
        }
    }

    public function calendarDisplayer()
    {
        $html = ""; //Variable permettant la concaténation de l'affichage final.
        $jour_semaine = 0; //Si == 0 => nouvelle semaine.

        //Affichage du calendrier.
        for ($i = 0; $i < count($this->dayArray); $i++) {
            //Ouverture de la tr.
            if ($jour_semaine == 0) {
                $html .= "<tr>";
                $jour_semaine++;
            }

            //Représente 6 itérations -> 6 jours. Qu'on affiche en td.
            if ($jour_semaine > 0 && $jour_semaine < 7) {
                $html .= "<td>" . $this->dayArray[$i] . "</td>";
                $jour_semaine++;
                //Pour le dernier jour de la semaine, il faut affiche le jour et close la tr.
            } else if ($jour_semaine == 7) {
                $html .= "<td>" . $this->dayArray[$i] . "</td>";
                $html .= "</tr>";
                $jour_semaine = 0;
            }
        }

        return $html;
    }
}
