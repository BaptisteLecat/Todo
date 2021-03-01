<?php

namespace App\Model\Utils;

use App\Model\Utils\DateFrench;
use App\Model\Entity\User;
use App\Model\Entity\Task;
use JsonSerializable;

/**
 * Class du Widget Calendar.
 */
class Calendar implements
    JsonSerializable
{

    private $day;
    private $first_day;
    private $first_day_index;
    private $last_day;
    private $current_dayArray;
    private $previous_dayArray;

    private $user;
    private $currentMonth_task;

    function __construct($timestamp = null, $user)
    {
        date_default_timezone_set('Europe/Paris');
        if ($timestamp === null) {
            $this->day = getdate();
        } else {
            $this->day = getdate(intval($timestamp));
        }
        $this->first_day = intval(date("d", mktime(0, 0, 0, $this->day["mon"], 1, $this->day["year"])));
        $this->first_day_index = intval(date("w", mktime(0, 0, 0, $this->day["mon"], 1, $this->day["year"])) - 1); // -1 car notre tableau commence à 0.
        //Le Mardi = 2 donc dans notre tableau == 1.
        $this->last_day = intval(date("d", mktime(0, 0, 0, $this->day["mon"] + 1, 0, $this->day["year"])));
        $this->current_dayArray = array();
        $this->previous_dayArray = array();
        $this->user = $user;
        $this->currentMonth_task = array();

        $this->dayBefore();
        $this->dayCurrent();
        $this->initCurrentMonthTask();
    }

    public function jsonSerialize()
    {
        return array(
            'day' => $this->day,
            'first_day' => $this->first_day,
            'first_day_index' => $this->first_day_index,
            'last_day' => $this->last_day,
            'current_dayArray' => $this->current_dayArray,
            'previous_dayArray' => $this->previous_dayArray,
            'userObject' => $this->user->jsonSerialize(),
            'currentMonth_task' => $this->currentMonth_task,
        );
    }

    /**
     * Fonction permettant de récupérer le jour en Francais.
     * Utilise une méthode de la classe static dateFrench.
     * @return string
     */
    public function getDay()
    {
        return dateFrench::dateTranslate($this->day["weekday"]);
    }

    /**
     * Fonction permettant de récupérer le mois en Francais.
     * Utilise une méthode de la classe static dateFrench.
     * @return string
     */
    public function getMonth()
    {
        return dateFrench::dateTranslate($this->day["month"]);
    }

    /**
     * Fonction permettant de récupérer l'année.
     * @return string
     */
    public function getYear()
    {
        return $this->day["year"];
    }

    /**
     * Fonction concernant les jours antérieur au mois courant.
     * first_day_index étant le nombre de jour antérieur.
     */
    private function dayBefore()
    {
        for ($i = $this->first_day_index; $i > 0; $i--) {
            $this->previous_dayArray[$i] = intval(date("d", mktime(0, 0, 0, $this->day["mon"], 1 - $i, $this->day["year"])));
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
        for ($i = 0; $i < $this->last_day; $i++) {
            $compteur_jour++;
            $this->current_dayArray[$i] = $compteur_jour;
        }
    }

    /**
     * Permet l'affichage HTML du widget Calendar.
     * @return string $html Contient l'affichage HTML.
     */
    public function calendarDisplayer()
    {
        //Variable permettant la concaténation de l'affichage final.
        $html = "<table>
        <thead>
          <th>Lun</th>
          <th>Mar</th>
          <th>Mer</th>
          <th>Jeu</th>
          <th>Ven</th>
          <th>Sam</th>
          <th>Dim</th>
        </thead>
        <tbody>";

        //Meme fonction que celle-ci, permet l'affichage des jours du mois précédent.
        $previousDay_response = $this->previousDayDisplayer();
        //On concatene le résultat dans le html.
        $html .= $previousDay_response["html"];
        //On continue au jour de la semaine auquel on s'est arrêté lors de l'affichage des jours du mois précédent.
        $jour_semaine = $previousDay_response["jour_semaine"]; //Si == 0 => nouvelle semaine.

        //Affichage du calendrier.
        for ($i = 0; $i < count($this->current_dayArray); $i++) {
            //Ouverture de la tr.
            if ($jour_semaine == 0) {
                $html .= "<tr>";
                $jour_semaine++;
            }

            //Représente 6 itérations -> 6 jours. Qu'on affiche en td.
            if ($jour_semaine >= 1 && $jour_semaine <= 6) {
                $html .= $this->dayManager($i);
                $jour_semaine++;
                //Pour le dernier jour de la semaine, il faut affiche le jour et close la tr.
            } else if ($jour_semaine == 7) {
                $html .= $this->dayManager($i);
                $html .= "</tr>";
                $jour_semaine = 0;
            }
        }

        $html .= "</tbody>
        </table>";

        return $html;
    }

    private function previousDayDisplayer()
    {
        //Variable permettant la concaténation de l'affichage final.
        $html = "";
        $jour_semaine = 0; //Si == 0 => nouvelle semaine.

        //Affichage du calendrier.
        foreach ($this->previous_dayArray as $previousDay) {
            //Ouverture de la tr.
            if ($jour_semaine == 0) {
                $html .= "<tr>";
                $jour_semaine++;
            }

            //Représente 6 itérations -> 6 jours. Qu'on affiche en td.
            if ($jour_semaine >= 1 && $jour_semaine <= 6) {
                $html .= "<td class='previousMonth'>" . $previousDay . "</td>";
                $jour_semaine++;
                //Pour le dernier jour de la semaine, il faut affiche le jour et close la tr.
            } else if ($jour_semaine == 7) {
                $html .= "<td class='previousMonth'>" . $previousDay . "</td>";
                $html .= "</tr>";
                $jour_semaine = 0;
            }
        }

        $response = ["html" => $html, "jour_semaine" => $jour_semaine];

        return $response;
    }

    /**
     * Gère l'affichage des Jours.
     * Il différencie: les jours du mois précédent, le jour d'aujourd'hui.
     * @param string $index Représente l'index dans le tableau de jour.
     * @return string $html Contient l'affichage html.
     */
    private function dayManager($index)
    {
        $html = "";

        //Test si c'est la date d'aujourd'hui.
        if ($this->current_dayArray[$index] == $this->day["mday"]) {
            $html .= "<td class='today'>" . $this->current_dayArray[$index] . "</td>";
        } else {
            if ($this->dayHaveTask($index) == true) {
                if ($this->dayStatus($index) == 1) {
                    $html .= "<td class='dayIsDo'>" . $this->current_dayArray[$index] . "</td>";
                } else {
                    $html .= "<td class='dayHaveTodo'>" . $this->current_dayArray[$index] . "</td>";
                }
            } else {
                $html .= "<td>" . $this->current_dayArray[$index] . "</td>";
            }
        }

        return $html;
    }

    /**
     * Remplit la liste des tâches pour le mois courant.
     * Permet d'éviter par la suite de parcourir toute les tâches du User.
     * @return void 
     */
    private function initCurrentMonthTask()
    {
        foreach ($this->user->getList_Task() as $task) {
            //Vérification de l'année et du mois de la tâche.
            $condition_year = date("y", strtotime($task->getEndDate())) == $this->day["year"];
            $condition_month = date("m", strtotime($task->getEndDate())) == $this->day["mon"];
            if ($condition_year && $condition_month) {
                array_push($this->currentMonth_task, $task);
            }
        }
    }

    /**
     * Verifie si un jour à une tâche associée.
     * @param string $index Représente l'index dans le tableau de jour.
     * @return bool $haveTask True si le jour à une tâche associée.
     */
    private function dayHaveTask($index)
    {
        $haveTask = false;
        if (empty($this->currentMonth_task) == false) { //Empty renvoie true si la valeur est vide.
            foreach ($this->currentMonth_task as $task) {
                if (date("d", strtotime($task->getEndDate())) == $index + 1) {
                    $haveTask = true;
                }
            }
        }

        return $haveTask;
    }

    /**
     * Permet de connaître l'état actif de la tâche.
     * @param string $index Représente l'index dans le tableau de jour.
     * @return bool $dayStatus True si le jour à une tâche associée.
     */
    private function dayStatus($index)
    {
        $dayStatus = 1; //Les tâches du jours sont réalisées.

        foreach ($this->currentMonth_task as $task) {
            if (date("d", strtotime($task->getEndDate())) == $index + 1) {
                if ($task->getActive() == 0) {
                    $dayStatus = 0;
                }
            }
        }

        return $dayStatus;
    }
}
