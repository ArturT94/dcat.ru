<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__));
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_WITH_ON_AFTER_EPILOG', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('STOP_STATISTICS', true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('highloadblock');


class SimpleXmlStreamer extends XmlStreamer
{
    public function processNode($xmlString, $elementName, $nodeIndex) {
        $xml = simplexml_load_string($xmlString);
        $array = json_decode(json_encode($xml), true);
        $attricutes = $array['@attributes'];
        unset($array['@attributes']);
        $arNewArray = array();
        foreach($attricutes as $key => $value)
            $arNewArray[strtoupper($key)] = $value;
        $arNewArray['FILIAL_CODE'] = 'M0';
        $ID = $this->addOrUpdateContragency($arNewArray);

        $arInformation = [];
        foreach($array['ContactInformation'] as $k => $infoArray)
        {
            $tmp = $infoArray['@attributes'];
            foreach($tmp as $key => $value)
                $arInformation[$k][strtoupper($key)] = $value;
            $arInformation[$k]['ENTITY_ID'] = $ID;
            if(is_int($ID))
                ContragencyAdditEntityTable::addorupdate($arInformation[$k]);
            elseif(is_array($ID))
                pr($ID);
        }
        echo "Item #{$ID} processed!<br/>";
        return true;
    }

    public function addOrUpdateContragency($arNewArray)
    {

        $currentListObject = ContragencyEntityTable::getList(array(
            'select' =>array('ID'),
            'order' => array('ID' =>'ASC'),
            'filter'=>array(
                '=UF_ACCOUNTNUMBER'=> $arNewArray['ACCOUNTNUMBER'],
                '=UF_NAMEFULL' => $arNewArray['NAMEFULL'],

            ),
        ));
        $currentItem = $currentListObject->Fetch();
        if(!empty($currentItem))
        {
            $ID = $currentItem['ID'];
            $result = ContragencyEntityTable::update($ID, $arNewArray);
        }
        else
        {
            $result = ContragencyEntityTable::add($arNewArray);
            $ID = $result->getId();
        }
        if($result->isSuccess()) {
            return $ID;
        }
        return  $result->getErrorMessages();
    }


}
$className = 'ContragencyEntityTable';
if (!$className::getEntity()->getConnection()->isTableExists($className::getTableName()))
{
    //$className::getEntity()->createDbTable();
    $className::createHLblock('Contragency', ['ru' => 'Контрагенты', 'en' => 'Contragency']);
}

$className = 'ContragencyAdditEntityTable';
if (!$className::getEntity()->getConnection()->isTableExists($className::getTableName()))
{
    $className::getEntity()->createDbTable();
}




$streamer = new SimpleXmlStreamer("contragency.xml");
if ($streamer->parse()) {
    echo "Finished successfully";
} else {
    echo "Couldn't find root node";
}


