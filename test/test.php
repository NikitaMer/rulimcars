<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST2");
CModule::IncludeModule("iblock");
CModule::IncludeModule("iblock");
$arElementList = array();
$rsElement = CIBlockElement::GetList(array(),array('IBLOCK_ID' => 12));
while ($arElement = $rsElement->Fetch())
{
    $arPropYear = CIBlockElement::GetProperty(12,$arElement['ID'],array(),array("CODE"=>"YEAR_CAR"))->Fetch();
    $arElementList[$arElement['ID']] = $arElement['NAME']." ".$arPropYear["VALUE"];
}
my_dump($arPropYear);
    
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>