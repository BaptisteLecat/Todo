<?php 

class XMLAppSettings extends SimpleXMLElement
{
    public function getDBCredentials()
    {
        $dbCredentials = array();
        foreach ($this->xpath('//dbCredentials')[0]->children() as $credential) {
            $dbCredentials[$credential->getName()] = $credential;
        }

        return $dbCredentials;
    }
}
