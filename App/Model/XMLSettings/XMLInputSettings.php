<?php

namespace App\Model\XMLSettings;

use SimpleXMLElement;

class XMLInputSettings extends SimpleXMLElement
{
    public function getPasswordConfig()
    {
        $passwordConfig = array();
        $passwordXML = $this->xpath('//password');
        if (!is_null($passwordXML)) {
            foreach ($passwordXML[0]->children() as $config) {
                $passwordConfig[$config->getName()] = $config;
            }
        }

        return $passwordConfig;
    }

    public function getEmailConfig()
    {
        $emailConfig = array();
        $emailXML = $this->xpath('//email');
        if (!is_null($emailXML)) {
            foreach ($emailXML[0]->children() as $config) {
                $emailConfig[$config->getName()] = $config;
            }
        }

        return $emailConfig;
    }

    public function getInputTextConfig()
    {
        $inputTextConfig = array();
        $inputTextXML = $this->xpath('//inputText');
        if (!is_null($inputTextXML)) {
            foreach ($inputTextXML[0]->children() as $config) {
                $inputTextConfig[$config->getName()] = $config;
            }
        }

        return $inputTextConfig;
    }
}
