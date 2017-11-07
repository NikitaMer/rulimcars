<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
$arElementList = array();
$rsElement = CIBlockElement::GetList(array(),array('IBLOCK_ID' => CAR_ID, 'ACTIVE' => "Y"), false, false, array("ID", "NAME", "PROPERTY_YEAR_CAR"));
while ($arElement = $rsElement->GetNext())
{
    $arElementList[0] = "Все";
    $arElementList[$arElement['ID']] = $arElement['NAME']." ".$arElement["PROPERTY_YEAR_CAR_VALUE"];
}
$arComponentParameters = Array(
"PARAMETERS" => Array(
   "CAR" => Array(
        "NAME" => GetMessage("CAR"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "DEFAULT" => "N",
        "VALUES" => $arElementList,
        "SIZE" => 7,        
   ), 
)
);