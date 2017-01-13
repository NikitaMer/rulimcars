<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST2");
CModule::IncludeModule("iblock");
    $request_post = 54;
    $res_car = array();
    $result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 12));                    
    while ($ob = $result->GetNextElement()){
        $res = $ob->GetFields();                        
        array_push($res_car,$res);                                     
    }        
    foreach ($res_car as $num){
        if ($num['ID'] == $request_post){
            $pic = CFile::GetPath($num['PREVIEW_PICTURE']);
        }
    }        
    echo ($pic);
    
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>