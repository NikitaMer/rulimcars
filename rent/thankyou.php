<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("H1", "Спасибо за обращение!");
$APPLICATION->SetTitle("Спасибо за обращение!");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");
CModule::IncludeModule("statistic");
CModule::IncludeModule("catalog");
$name = $_POST["NAME"];    
$phone = $_POST["PHONE"];
$auto = $_POST["AUTO"];
$email = $_POST["EMAIL"];
$text = $_POST["TEXT"];
$date = $_POST["DATE"];
$res =  $_POST["RESULT"];
$rent = $_POST["RENT"];
if ($name != null && $phone != null){
    $el = new CIBlockElement;
    
    $PROP = array();
    $PROP["CAR"] = $auto;  
    $PROP["PHONE"] = $phone;        
    $PROP["EMAIL"] = $email;
    $PROP["NAME"] = $name;
    $PROP["DATE"] = $date;
    $PROP["RESULT"] = $res;
    $PROP["RENT"] = $rent;
    $PROP["COMMENT"] = $text;         
    $arLoadProductArray = Array(
        "IBLOCK_SECTION_ID" => false,        
        "IBLOCK_ID"      => 10,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $name,
        "ACTIVE"         => "Y",          
        "DETAIL_TEXT"    => $text,
    ); 
    $el->Add($arLoadProductArray);
    
    $cso = new CSaleOrder;
    $csb = new CSaleBasket;                               

    $CBE = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17));
    while($CBEcar = $CBE->Fetch()){ 
        $CBEprop = CIBlockElement::GetProperty(17, $CBEcar['ID'])->Fetch();   
    if ($CBEprop['VALUE'] == $auto){
        $productid = $CBEcar; 
    }           
    }   
    $CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17)); 
    $dayprice = array(); 
    while($CPrice1 = $CPrice->Fetch()){
    if ($CPrice1['PRODUCT_ID'] == $productid['ID'])   
        $dayprice[] = $CPrice1;       
    }  
    foreach ($dayprice as $prop): 
        if ($prop['QUANTITY_FROM']<=$rent && $prop['QUANTITY_TO']>=$rent):
            $res = $prop['PRICE'];
        elseif($prop['QUANTITY_TO']==null):
            $res = $prop['PRICE'];   
        endif;   
    endforeach;
     
    $product = array('ID' => $productid['ID'], 'NAME' => $productid['NAME'], 'PRICE' => $res, 'CURRENCY' => 'RUB', 'QUANTITY' => $rent);
                
$basket = Bitrix\Sale\Basket::create(SITE_ID);


$item = $basket->createItem("catalog", $product["ID"]);
unset($product["ID"]);
$item->setFields($product);
    
$order = Bitrix\Sale\Order::create(SITE_ID, 1);
$order->setPersonTypeId(1);
$order->setBasket($basket);
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById(1));

//$shipmentItemCollection = $shipment->getShipmentItemCollection();

//$item = $shipmentItemCollection->createItem($basketItem);
//$item->setQuantity($basketItem->getQuantity());


$paymentCollection = $order->getPaymentCollection();
$payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById(1));
$payment->setField("SUM", $order->getPrice());
$payment->setField("CURRENCY", $order->getCurrency());

    $result = $order->save();    
    ?>

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
}
$car = GetIBlockElement($auto); 
?>
<script type="text/javascript">
$(document).ready(function () {
    var carName = {'Name' : '<?=$car['NAME']?>'};
    OrderCar(<?=$order['ID']?>,<?=$res?>, null, carName['Name'], <?=$car['PROPERTIES']['YEAR_CAR']['VALUE']?>, <?=$car['ID']?>, <?=$res/$rent?>, <?=$rent?>);
});
</script>
    <?=$name?>, Вы оформили заявку №<?=$order['ID']?> на аренду автомобиля <?=$car['NAME']?><?if ($rent != 0){?> сроком на <?=$rent?> суток, стоимость <?=$res?> руб. (<?=$res/$rent?> руб/суток). <?}else{?>.<?}?> 
    <?if ($email != null){?>На адрес <?=$email?> отправлена информация с детализацией вашей заявки.<?}?>
    В ближайшее время с вами свяжется сотрудник нашей компании и обсудит с вами детали, вы так же можете позвонить самостоятельно по бесплатному номеру 8(800)777 59 90.
<?}?>
</div>   

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>