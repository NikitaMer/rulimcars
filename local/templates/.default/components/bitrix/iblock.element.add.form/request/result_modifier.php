<?
    $AUTO = $_GET['AUTO'];
    if (AUTO != null):
        $result =  GetIBlockElement($AUTO);
        $arResult['RES_CAR'] = $result;   
    endif;