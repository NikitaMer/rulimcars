<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?  
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("statistic");
    CModule::IncludeModule("catalog");
    //передаваемые данные
    $name = $_POST["NAME"];    
    $phone = $_POST["PHONE"];
    $auto = $_POST["AUTO"];
    $email = $_POST["EMAIL"];
    $text = $_POST["TEXT"];
    $date = $_POST["DATE"];
    $res =  $_POST["RESULT"];
    $rent = $_POST["RENT"];
                            
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
    if ($el->Add($arLoadProductArray) ) {
        echo "OK";
    } else {
        echo "ERROR_L";    
    } 
    
    
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

        
    if ($result = $order->save()) {
        echo "OK";
    } else {
        echo "ERROR_F";    
    }    