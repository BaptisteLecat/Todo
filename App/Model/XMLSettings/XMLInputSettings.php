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

    public function getTitleTaskConfig()
    {
        $titleTaskConfig = array();
        $titleTaskXML = $this->xpath('//titleTask');
        if (!is_null($titleTaskXML)) {
            foreach ($titleTaskXML[0]->children() as $config) {
                $titleTaskConfig[$config->getName()] = $config;
            }
        }

        return $titleTaskConfig;
    }

    public function getContentTaskConfig()
    {
        $contentTaskConfig = array();
        $contentTaskXML = $this->xpath('//contentTask');
        if (!is_null($contentTaskXML)) {
            foreach ($contentTaskXML[0]->children() as $config) {
                $contentTaskConfig[$config->getName()] = $config;
            }
        }

        return $contentTaskConfig;
    }

    public function getEndDateTaskConfig()
    {
        $endDateTaskConfig = array();
        $endDateTaskXML = $this->xpath('//endDateTask');
        if (!is_null($endDateTaskXML)) {
            foreach ($endDateTaskXML[0]->children() as $config) {
                $endDateTaskConfig[$config->getName()] = $config;
            }
        }

        return $endDateTaskConfig;
    }

    public function getTitleTodoConfig()
    {
        $titleTodoConfig = array();
        $titleTodoXML = $this->xpath('//titleTodo');
        if (!is_null($titleTodoXML)) {
            foreach ($titleTodoXML[0]->children() as $config) {
                $titleTodoConfig[$config->getName()] = $config;
            }
        }

        return $titleTodoConfig;
    }

    public function getDescriptionTodoConfig()
    {
        $descriptionTodoConfig = array();
        $descriptionTodoXML = $this->xpath('//descriptionTodo');
        if (!is_null($descriptionTodoXML)) {
            foreach ($descriptionTodoXML[0]->children() as $config) {
                $descriptionTodoConfig[$config->getName()] = $config;
            }
        }

        return $descriptionTodoConfig;
    }
}
