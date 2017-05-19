<?php 
require_once(dirname(__FILE__) . "/include/.config.php");
function arshow($array, $adminCheck = false) {
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
/**
*  Ставим / в конце URL если его нет 
*/
AddEventHandler("main", "OnProlog", "checkSlash");
    function checkSlash(){
        global $APPLICATION;
        $url = $APPLICATION->GetCurPage();
        $url_last_symbol = substr($url, -1);        
        $url_3_last_symbol = substr($url, -3);
        if ($url_last_symbol != "/" && $url_3_last_symbol != "php"){
            LocalRedirect($url."/", true, "301 Moved permanently");
        }          
        
    }
/**
* Отправка письма при добавлении в инфоблок Заявки
*/

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
function OnAfterIBlockElementAddHandler(&$arFields) {
  $SITE_ID = 's1'; 
  $IBLOCK_ID = 10; 
  $EVENT_TYPE = 'NEW_ELEMENT_INFOBLOCK'; 
  if($arFields['IBLOCK_ID']==$IBLOCK_ID) {
    $arQuestion = CIBlockElement::GetByID($arFields['ID'])->GetNextElement()->GetProperties();
    $arCarProp = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetProperties();
    $arCar = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNext();
    $arCarPic = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetFields();
    $DateTimeCreate = CIBlockElement::GetByID($arFields['ID'])->GetNextElement()->GetFields();
    $DateCreate = strstr(str_replace(".","_",$DateTimeCreate['DATE_CREATE'])," ", true);
    $arMailFields = array(
        'NAME' => $arQuestion['NAME']['VALUE'],
        'ID' => $arFields['ID'],
        'DATA' => $arQuestion['DATE']['VALUE'],
        'RENT' => $arQuestion['RENT']['VALUE'],
        'RESULT' => $arQuestion['RESULT']['VALUE'],
        'EMAIL' => $arQuestion['EMAIL']['VALUE'],
        'PHONE' => $arQuestion['PHONE']['VALUE'],
        'RESULT_DAY' => $arQuestion['RESULT']['VALUE']/$arQuestion['RENT']['VALUE'],
        'COMMENT' => $arQuestion['COMMENT']['VALUE'],
        'NAME_CAR' => $arCar['NAME'],
        'YEAR_CAR' => $arCarProp['YEAR_CAR']['VALUE'],
        'DETAIL_CAR' => $arCarPic['DETAIL_PAGE_URL'],
        'TYPE_CAR_CIR' => $arCarProp['TYPE_CAR_CIR']['VALUE'],
        'TYPE_CAR_LAT' => $arCarProp['TYPE_CAR_CIR']['DESCRIPTION'],
        'CAR_PICTURE' => "http://".$_SERVER['HTTP_HOST'].CFile::GetPath($arCarPic['DETAIL_PICTURE']),
        'DATE_CREATE' => $DateCreate,
    );
    if($arMailFields['RENT'] == 0 ) {
        CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", 47);
    }else{
        CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", 46);
    }      
  }
}