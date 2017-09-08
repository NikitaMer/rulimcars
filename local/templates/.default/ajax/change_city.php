<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("statistic");
    CModule::IncludeModule("catalog");
    
    $city_id = $_POST["city"];
    
    $CIBE = new CIBlockElement;
    if($city_id != 0){
        $rsCar = $CIBE->GetList(array(),array('IBLOCK_ID' => 12, 'PROPERTY_CITY' => $city_id, 'PROPERTY_SHOW_CAR' => 13), false, false, array("ID","NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));
        $rsOffice = $CIBE->GetList(array(),array('IBLOCK_ID' => 19, 'IBLOCK_SECTION_ID' => $city_id, 'PROPERTY_TYPE_BUILDING' => 22), false, false, array("ID","NAME", "PROPERTY_TYPE_BUILDING"));            
        $rsAirport = $CIBE->GetList(array(),array('IBLOCK_ID' => 19, 'IBLOCK_SECTION_ID' => $city_id, 'PROPERTY_TYPE_BUILDING' => 23), false, false, array("ID","NAME", "PROPERTY_TYPE_BUILDING"));            
    }else{
        $rsCar = $CIBE->GetList(array(),array('IBLOCK_ID' => 12, 'PROPERTY_SHOW_CAR' => 13), false, false, array("ID","NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));                    
    }
    
    while ($arCar = $rsCar->GetNext()) {
        $arResult["CAR"] .= "<option data_path=\"".CFile::GetPath($arCar['PREVIEW_PICTURE'])."\" value=\"".$arCar["ID"]."\">
                        ".$arCar["NAME"]." ".$arCar['PROPERTY_YEAR_CAR_VALUE']."
                    </option>";                                                           
    }
    if($rsOffice){
        while ($arOffice = $rsOffice->GetNext()) {
            $arResult["OFFICE"] .= "<option value=\"".$arOffice["ID"]."\">".$arOffice["NAME"]." </option>";                                                           
        }    
    }
    if($rsAirport){
        while ($arAirport = $rsAirport->GetNext()) {
            $arResult["AIRPORT"] .= "<option value=\"".$arAirport["ID"]."\">".$arAirport["NAME"]." </option>";                                                           
        }    
    } 
    
    
    echo json_encode($arResult);
?>