<?php

namespace App\Model\Utils;

use Exception;
use App\Model\VisitorCounterManager;
use Mobile_Detect;

class VisitorCounter
{
    private static $instanceCount = 0;

    public function __construct()
    {
        self::$instanceCount++;

        $visitor_ip = $this->getIp();
        if ($visitor_ip != null) {
            VisitorCounterManager::insertVisitor($visitor_ip, $this->getDevice());
        } else {
            throw new Exception("Identification du visiteur impossible.");
        }
    }

    public static function getInstanceCount()
    {
        return self::$instanceCount;
    }

    public function __destruct()
    {
        self::$instanceCount = (self::$instanceCount > 0) ? self::$instanceCount-- : 0;
    }

    private function getIp()
    {
        $ip = null;

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    private function getDevice()
    {
        $device = "Desktop";
        $mobiledetect = new Mobile_Detect();

        if ($mobiledetect->isMobile()) {
            $device = "Mobile";
        } else {
            if ($mobiledetect->isTablet()) {
                $device = "Tablet";
            }
        }

        return $device;
    }
}
