<?php

namespace App\Model\XMLSettings;

use SimpleXMLElement;
class XMLErrorDatabase extends SimpleXMLElement
{
    public function getErrorDatabase()
    {
        $errorDatabase = array();
        $errorXML = $this->xpath('//error');
        if (!is_null($errorXML)) {
            foreach ($errorXML as $error) {
                $errorDatabase[intval($error->children()[0])] = (string)$error->children()[1];
            }
        }

        return $errorDatabase;
    }
}
