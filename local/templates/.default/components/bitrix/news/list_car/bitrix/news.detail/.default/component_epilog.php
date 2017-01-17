<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
CModule::IncludeModule("iblock");
$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arResult['IBLOCK_ID'],$arResult['ID']); 

$IPROPERTY = $ipropValues->getValues();    
    
    //$APPLICATION->SetTitle($IPROPERTY['ELEMENT_PAGE_TITLE']);
    $APPLICATION->SetPageProperty("H1", $IPROPERTY['ELEMENT_PAGE_TITLE']);
    
    
?>