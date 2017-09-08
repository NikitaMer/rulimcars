<?
    $AUTO = $_POST['AUTO'];
    if (AUTO != null):
        $result =  GetIBlockElement($AUTO);
        $arResult['RES_CAR'] = $result;   
    endif;
foreach ($arResult["PROPERTY_LIST_FULL"] as $propertyID):            
    $id = $propertyID["LINK_IBLOCK_ID"];                                
    if ($id == 12):        
        $result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $id,'ACTIVE' => 'Y'));                    
        while ($ob = $result->GetNextElement()){  
            $res = $ob->GetFields();            
            $all_props = CIBlockElement::GetProperty($id, $res['ID'],array(),array('ACTIVE' => 'Y'));
            $arResult['ALL_CAR'][$res['ID']]=$res;
            while($ar_props = $all_props->GetNext()){                                
                $arResult['ALL_CAR'][$res['ID']]['PROPERTIES'][$ar_props['CODE']] = $ar_props['VALUE'];                
            }
            /*
            $cprice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arResult['ALL_CAR'][$res['ID']]['PROPERTIES']['CATALOG'],));
            while($cprice1 = $cprice->Fetch()){
                $arResult['ALL_CAR'][$res['ID']]['PRICE'][] = $cprice1;
            }
            */                                 
        }    
    endif;            
endforeach;