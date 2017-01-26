<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST");?>

<?
    CModule::IncludeModule("iblock");
    $arQuestion = CIBlockElement::GetByID(297)->GetNextElement()->GetProperties();
    $arCar = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetProperties();
    $arCarPic = CIBlockElement::GetByID($arQuestion['CAR']['VALUE'])->GetNextElement()->GetFields();
    $DateTimeCreate = CIBlockElement::GetByID(297)->GetNextElement()->GetFields();
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
  my_dump($arCar);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>