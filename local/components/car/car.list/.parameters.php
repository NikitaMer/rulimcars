<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
$arElementList = array();
$rsElement = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 12));
while ($arElement = $rsElement->Fetch())
{
    $arPropYear = CIBlockElement::GetProperty(12,$arElement['ID'],array(),array("CODE"=>"YEAR_CAR"))->Fetch();
    $arElementList[$arElement['ID']] = $arElement['NAME']." ".$arPropYear["VALUE"];
}
$arComponentParameters = Array(
"PARAMETERS" => Array(
   "CAR" => Array(
        "NAME" => GetMessage("CAR"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "DEFAULT" => "N",
        "VALUES" => $arElementList,
        "SIZE" => 4,        
   ),
   "TYPE_SORT" => Array(
             "NAME" => GetMessage("SORTING"),
             "TYPE" => "LIST",
             "VALUES" => array('ID' => 'По списку', 'RAND' => 'Случайно'),
        ),
)
);