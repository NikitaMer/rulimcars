<?
foreach($arResult["ITEMS"] as $key=>$arItem):
    // Получаем цены
    CModule::IncludeModule("catalog");
    $CIBE = new CIBlockElement;
    
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($arItem["IBLOCK_ID"]);       
    $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $arItem["ID"]), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT"));
    while ($arOffer = $rsOffers->GetNext()) {
        $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arOffer["ID"]));
        while($arPrice = $rsPrice->Fetch()){             
            if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За сутки") { 
                $arResult["ITEMS"][$key]['DAY_PRICE'][] = $arPrice;    
            } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За час") {
                $arResult["ITEMS"][$key]['HOUR_PRICE'][] = $arPrice;
            }        
        }             
    }
    
endforeach;