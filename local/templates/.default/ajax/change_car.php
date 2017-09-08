<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("statistic");
    CModule::IncludeModule("catalog"); 
    
    $newcar = $_POST["newcar"];
    $oldcar = $_POST["oldcar"];
    
    $arResult["ERROR"] == false;
    $CIBE = new CIBlockElement;
    
    //Определяем все для нового выбранного автомобиля 
    $result = $CIBE->GetList(array(), array("ID" => $newcar), false, false, array("ID","NAME", "IBLOCK_ID", "PROPERTY_YEAR_CAR"))->GetNext();
    
    $arResult["NEW_CAR"]["YEAR"] = $result["PROPERTY_YEAR_CAR_VALUE"];
    $arResult["NEW_CAR"]["NAME"] = $result["NAME"];
    
    $arInfo = CCatalogSKU::GetInfoByProductIBlock($result["IBLOCK_ID"]);   
    
    if (is_array($arInfo)) {
        $Offer = array();                  
        $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $newcar), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT")); 
        while ($arOffer = $rsOffers->GetNext()) {
            if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За сутки") {
                $type = "DAY";    
            } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За час") {
                $type = "HOUR";  
            } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "Трансфер") {
                $type = "TRANSFER";  
            }
            $arResult["NEW_CAR"]["PRICES"][$arOffer["ID"]]["TYPE_RENT"] = $type;                                  
            array_push($Offer, $arOffer["ID"]);             
        }
        if($Offer){           
            $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $Offer));
            $key = 0;
            while ($arPrice = $rsPrice->Fetch()) {
                $arResult["NEW_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["QUANTITY_FROM"] = $arPrice["QUANTITY_FROM"];    
                $arResult["NEW_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["QUANTITY_TO"] = $arPrice["QUANTITY_TO"];    
                $arResult["NEW_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["PRICE"] = stristr($arPrice["PRICE"], '.', true);
                $key++;    
            }    
        }                    
    }
    
    if($oldcar){
        //Определяем все для старого выбранного автомобиля 
        $result = $CIBE->GetList(array(), array("ID" => $oldcar), false, false, array("ID","NAME", "IBLOCK_ID", "PROPERTY_YEAR_CAR"))->GetNext();
        
        $arResult["OLD_CAR"]["YEAR"] = $result["PROPERTY_YEAR_CAR_VALUE"];
        $arResult["OLD_CAR"]["NAME"] = $result["NAME"];
        
        $arInfo = CCatalogSKU::GetInfoByProductIBlock($result["IBLOCK_ID"]);  
        if (is_array($arInfo)) {
            $Offer = array();                  
            $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => $arInfo['IBLOCK_ID'], 'PROPERTY_'.$arInfo['SKU_PROPERTY_ID'] => $oldcar), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT")); 
            while ($arOffer = $rsOffers->GetNext()) {
                if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За сутки") {
                    $type = "DAY";    
                } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "За час") {
                    $type = "HOUR";  
                } else if ($arOffer["PROPERTY_TYPE_RENT_VALUE"] == "Трансфер") {
                    $type = "TRANSFER";  
                }
                $arResult["OLD_CAR"]["PRICES"][$arOffer["ID"]]["TYPE_RENT"] = $arOffer["PROPERTY_TYPE_RENT_VALUE"];                                  
                array_push($Offer, $arOffer["ID"]);             
            }
            if($Offer){           
                $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $Offer));
                $key = 0;
                while ($arPrice = $rsPrice->Fetch()) {
                    $arResult["OLD_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["QUANTITY_FROM"] = $arPrice["QUANTITY_FROM"];    
                    $arResult["OLD_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["QUANTITY_TO"] = $arPrice["QUANTITY_TO"];    
                    $arResult["OLD_CAR"]["PRICES"][$arPrice["PRODUCT_ID"]]["OFFER"][$key]["PRICE"] = stristr($arPrice["PRICE"], '.', true);
                    $key++;    
                }    
            }                    
        }
    }
                            
    if($arResult["NEW_CAR"] == null){
       $arResult["ERROR"] == true; 
    }                    
    echo json_encode($arResult);
?>