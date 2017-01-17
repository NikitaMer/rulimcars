<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("H1", "Спасибо за обращение!");
$APPLICATION->SetTitle("Спасибо за обращение!");
CModule::IncludeModule("iblock");
$name = $_POST["NAME"];
$phone = $_POST["PHONE"];
$auto = $_POST["AUTO"];
$email = $_POST["EMAIL"];
$date = $_POST["DATE"];
$res =  $_POST["RESULT"];
$rent = $_POST["RENT"];?>

<div class="content">
<?
$CBEor = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 10));
while($CBEorder = $CBEor->Fetch()){    
    if ($CBEorder['NAME'] == $name){
        $order = $CBEorder; 
    }
} 
$Corder = CIBlockElement::GetProperty(10, $order['ID']);
$proporder = array();
while($Cproporder = $Corder->Fetch()){
    $proporder[$Cproporder['NAME']] =  $Cproporder['VALUE'];  
}//my_dump($proporder);
$CBEc = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 12));
while($CBEcar = $CBEc->Fetch()){    
    if ($CBEcar['ID'] == $auto){
        $car = $CBEcar; 
    }
}
if ($name != null && $phone != null){
?>
    <?=$name?>, Вы оформили заявку №<?=$order['ID']?> на аренду автомобиля <?=$car['NAME']?><?if ($rent != 0){?> сроком на <?=$rent?> суток, стоимость <?=$res?> руб. (<?=$res/$rent?> руб/суток). <?}else{?>.<?}?> 
    <?if ($email != null){?>На адрес <?=$email?> отправлена информация с детализацией вашей заявки.<?}?>
    В ближайшее время с вами свяжется сотрудник нашей компании и обсудит с вами детали, вы так же можете позвонить самостоятельно по бесплатному номеру 8(800)777 59 90.
<?}?>
</div>    

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>