<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    CModule::IncludeModule("iblock");
    $request_post = $_POST["CARID"];
    $res_car = array();
    $result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 12));                    
    while ($ob = $result->GetNextElement()){
        $res = $ob->GetFields();                        
        array_push($res_car,$res);                                     
    }
    my_dump($res_car);        
    foreach ($res_car as $num){
        if ($num['ID'] == $request_post){
            $pic = CFile::GetPath($num['PREVIEW_PICTURE']);
        }
    }        
    echo $pic;
?>