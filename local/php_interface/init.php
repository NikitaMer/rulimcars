<?php 
function my_dump($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}
/**
* Редирект на страницу со / в конце* 
*/
function checkSlash(){
    global $APPLICATION;
    $url = $APPLICATION->GetCurPage();
    $url_last_symbol = substr($url, -1);
    if ($url_last_symbol != "/"){
        LocalRedirect($url."/", true, "301 Moved permanently");
    }
}
/**
* Отправка письма при добавление элемента в инфоблок Заявки
*/
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MyClass", "OnAfterIBlockElementAddHandler")); 
class MyClass 
{ 
function OnAfterIBlockElementAddHandler(&$arFields) {
  $SITE_ID = 's1'; 
  $IBLOCK_ID = 10; 
  $EVENT_TYPE = 'NEW_ELEMENT_INFOBLOCK'; 
  if($arFields['IBLOCK_ID']==$IBLOCK_ID) {
    $arQuestion = CIBlockElement::GetByID($arFields['ID'])->GetNextElement()->GetProperties();
    $arCar = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetProperties();
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
        'NAME_CAR' => $arCar['NAME_CAR']['VALUE'],
        'YEAR_CAR' => $arCar['YEAR_CAR']['VALUE'],
        'DETAIL_CAR' => $arCarPic['DETAIL_PAGE_URL'],
        'TYPE_CAR_CIR' => $arCar['TYPE_CAR_CIR']['VALUE'],
        'TYPE_CAR_LAT' => $arCar['TYPE_CAR_LAT']['DESCRIPTION'],
        'CAR_PICTURE' => CFile::GetPath($arCarPic['DETAIL_PICTURE']),
        'DATE_CREATE' => $DateCreate,
    );
    if($arMailFields['RENT'] == 0 ) {
        CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", 47);
    }else{
        CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", 46);
    }
  }
}
}