<?php

namespace App\Model\Utils;

class DateFrench
{
    public static $englishdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    public static $frenchdays = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    public static $englishmonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    public static $frenchmonths = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

    /**
     * Permet d'afficher le jour d'une date en francais .
     * @param stringDate La string de la date.
     * @return date Date format l: "Lundi".
    */
    public static function dateToDay($stringDate){
        return str_replace(self::$englishdays, self::$frenchdays, date("l", $stringDate));
    }

    public static function dateTranslate($dateElement){
        $translateElement = "";

        foreach(self::$englishdays as $day){
            if($day == $dateElement){
                $translateElement = str_replace(self::$englishdays, self::$frenchdays, $dateElement);
                break;
            }
        }

        if($translateElement == ""){
            foreach(self::$englishmonths as $month){
                if($month == $dateElement){
                    $translateElement = str_replace(self::$englishmonths, self::$frenchmonths, $dateElement);
                    break;
                }
            }
        }

        return $translateElement;
    }

    /**
     * Permet d'afficher une date au format francais.
     * @param stringDate La string de la date.
     * @return date Date format d-m-Y: "19-02-2018".
    */
    public static function dateToString($stringDate){
        return date('d-m-Y', strtotime($stringDate));
    }

    /**
     * Permet de récuperer la date de INDEX jour avant ou après la date actuelle.
     * @param Index Prend +i ou -i.
     * @return date Date format Y-m-d.
    */
    public static function dateFromIndex($index){
        return date('Y-m-d', strtotime( $index.' day'));
    }
}
