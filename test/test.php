<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST2");
CModule::IncludeModule("iblock");
$DataTime = CIBlockElement::GetByID(239)->GetNextElement()->GetFields();
//$arCar = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetProperties();
//$arCarPic = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetFields();
      $Data = strstr(str_replace(".","_",$DataTime['DATE_CREATE'])," ", true);
  my_dump($Data);
    
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>