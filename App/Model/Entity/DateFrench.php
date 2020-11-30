<?php

namespace App\Model\Entity;

class DateFrench
{
    public static $englishdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    public static $frenchdays = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    public static $englishmonths = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    public static $frenchmonths = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');

    /**
     * Permet d'afficher le jour d'une date en francais .
     * @param stringDate La string de la date.
     * @return date Date format l: "Lundi".
    */
    public static function dateToDay($stringDate){
        return str_replace(self::$englishdays, self::$frenchdays, date("l", $stringDate));
    }

    /**
     * Permet d'afficher une date au format francais.
     * @param stringDate La string de la date.
     * @return date Date format d-m-Y: "19-02-2018".
    */
    public static function dateToString($stringDate){
        return date('d-m-Y', $stringDate);
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
