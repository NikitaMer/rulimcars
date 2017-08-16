<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?  
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
    
$car_catolog = CIBlockElement::GetProperty(12, $auto, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->Fetch();        
$catolog = GetIBlockElement($car_catolog['VALUE']);     
$product = array(
    'ID' => $car_catolog['VALUE'], 
    'NAME' => $catolog['NAME'], 
    'PRICE' => $res/$rent, 
    'CURRENCY' => 'RUB', 
    'QUANTITY' => $rent,    
);
              
$basket = Bitrix\Sale\Basket::create(SITE_ID);
$item = $basket->createItem("catalog", $product['ID']);

unset($product["ID"]);
$item->setFields($product);

$order = Bitrix\Sale\Order::create(SITE_ID, 1);
$order->setPersonTypeId(1);
$order->setBasket($basket);
$order->setField('USER_DESCRIPTION', $text);
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