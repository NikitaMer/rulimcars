<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");
if ($arParams['CAR'][0] == 0) {
    $dbCar = CIBlockElement::GetList(array(),array('IBLOCK_ID' => CAR_ID, 'ACTIVE' => "Y", "PROPERTY_SHOW_CAR_VALUE" => "Отображать автомобиль"), false, false, array("ID", "NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));
    while ($arCar = $dbCar->GetNext()) {
       $arResult['CAR'][$arCar["ID"]]["NAME"] = $arCar["NAME"]." ".$arCar["PROPERTY_YEAR_CAR_VALUE"];      
       $arResult['CAR'][$arCar["ID"]]["PREVIEW_PICTURE"] = $arCar["PREVIEW_PICTURE"];      
    }        
} else {
    $dbCar = CIBlockElement::GetList(array(),array("ID" => $arParams['CAR'], 'IBLOCK_ID' => CAR_ID, 'ACTIVE' => "Y", "PROPERTY_SHOW_CAR_VALUE" => "Отображать автомобиль"), false, false, array("ID", "NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));
    while ($arCar = $dbCar->GetNext()) {
       $arResult['CAR'][$arCar["ID"]]["NAME"] = $arCar["NAME"]." ".$arCar["PROPERTY_YEAR_CAR_VALUE"];
       $arResult['CAR'][$arCar["ID"]]["PREVIEW_PICTURE"] = $arCar["PREVIEW_PICTURE"];       
    } 
} 
$dbCity = CIBlockSection::GetList(array(), array("IBLOCK_ID" => CITY_ID,'ACTIVE' => 'Y'));
while ($arCity = $dbCity->GetNext()) {
   $arResult['CITY'][] = $arCity; 
}

$this->IncludeComponentTemplate();
?>