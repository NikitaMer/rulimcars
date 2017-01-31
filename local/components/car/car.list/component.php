<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
if ($arParams['TYPE_SORT'] == "RAND"){shuffle($arParams['CAR']);}
foreach ($arParams['CAR'] as $key=>$Params){
$arResult['CAR'][] = GetIBlockElement($Params);
}
$arParams['TYPE_SORT'];
$this->IncludeComponentTemplate();
?>