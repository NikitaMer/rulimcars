<?

CModule::IncludeModule("catalog");
$CIBE = new CIBlockElement;

$arInfo = CCatalogSKU::GetInfoByProductIBlock($arResult["IBLOCK_ID"]);       
$rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arResult["ID"]), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT"));
while ($arOffer = $rsOffers->GetNext()) {
    $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arOffer["ID"]));
    while ($arPrice = $rsPrice->Fetch()) {                     
        if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За сутки") { 
            $arResult['DAY_PRICE'][] = $arPrice;    
        } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За час") {
            $arResult['HOUR_PRICE'][] = $arPrice;
        }        
    }             
}
//
foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] as $key=>$arItem):
    $car_prop = GetIBlockElement($arItem);
    $car_catolog = CIBlockElement::GetProperty($arItem, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->GetNext();
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["ID"] = $arItem;
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["PREVIEW_PICTURE"] = CFile::GetPath($car_prop["PREVIEW_PICTURE"]);
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["DETAIL_PAGE_URL"] = $car_prop["DETAIL_PAGE_URL"];
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["NAME"] = $car_prop["NAME"];
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($arItem["IBLOCK_ID"]);       
    $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arItem["ID"]), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT"));
    while ($arOffer = $rsOffers->GetNext()) {
        $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arOffer["ID"]));
        while ($arPrice = $rsPrice->Fetch()) {                     
            if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За сутки") { 
                $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["PRICE"]['DAY_PRICE'][] = $arPrice;    
            } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За час") {
                $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["PRICE"]['HOUR_PRICE'][] = $arPrice;
            }        
        }             
    } 
endforeach;