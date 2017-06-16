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
    if ($_SESSION['id'] != 1 ){
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
        // Добавляем заявку в инфоблок "Заявки" 
        $el->Add($arLoadProductArray);

        $car_catolog = CIBlockElement::GetProperty(12, $auto, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->Fetch();        
        $catolog = GetIBlockElement($car_catolog['VALUE']);     
        $product = array(
            'ID' => $car_catolog['VALUE'], 
            'NAME' => $catolog['NAME'], 
            'PRICE' => $res/$rent, 
            'CURRENCY' => 'RUB', 
            'QUANTITY' => $rent,    
        );
        // Генерируем случайный 
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        $pass = "";
        for($i = 0; $i < 6; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        // Создаем пользователя
        $user = new CUser;
        $rnd = substr($pass,0,-3);
        $arFields = Array(
            "NAME"              => $name,
            "EMAIL"             => $email,
            "LOGIN"             => $name.$rnd,
            "PERSONAL_PHONE"    => $phone,
            "LID"               => SITE_ID,
            "ACTIVE"            => "Y",
            "GROUP_ID"          => array(CLIENT_GROUP_ID),
            "PASSWORD"          => $pass,
            "CONFIRM_PASSWORD"  => $pass,
        );
        $user_ID = $user->Add($arFields);

        $basket = Bitrix\Sale\Basket::create(SITE_ID);
        $item = $basket->createItem("catalog", $product['ID']);
        unset($product["ID"]);
        $item->setFields($product);
        $order = Bitrix\Sale\Order::create(SITE_ID, $user_ID);
        $order->setPersonTypeId(CLIENT_GROUP_ID);
        $order->setBasket($basket);
        $order->setField('USER_DESCRIPTION', $text);

        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(Bitrix\Sale\Delivery\Services\Manager::getObjectById(CLIENT_GROUP_ID));

        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($basket as $basketItem)
        {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }

        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById(CLIENT_GROUP_ID));
        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());
        $propertyCollection = $order->getPropertyCollection();
        if ($name  != null){$somePropValueName = $propertyCollection->getItemByOrderPropertyId(1)->setValue($name);}
        if ($phone != null){$somePropValuePhone = $propertyCollection->getItemByOrderPropertyId(2)->setValue($phone);}
        if ($email != null){$somePropValueEmail = $propertyCollection->getItemByOrderPropertyId(3)->setValue($email);}
        $result = $order->save();
    }
?>

<div class="content">
    <?
        if ($name != null && $phone != null){
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

           /*
            ga('require', 'ecommerce');
            var carName = {'Name' : '<?=$car['NAME']?>'};
            OrderCar('<?=$order['ID']?>','<?=$res?>', null, carName['Name'], '<?=$car['PROPERTIES']['YEAR_CAR']['VALUE']?>', '<?=$car['ID']?>', '<?=$res/$rent?>', '<?=$rent?>');
            // код электронной коммерции
            ga('ecommerce:addTransaction', {
                'id': '<?=$order['ID']?>',                     // Transaction ID. Required.
                'affiliation': 'Rulimcars',   // Affiliation or store name.
                'revenue': '<?=$res?>',               // Grand Total.
                'shipping': '0',                  // Shipping.
                'tax': '0'                     // Tax.
            });


            ga('ecommerce:addItem', {
                'id': '<?=$order['ID']?>',
                'name': '<?=$car['NAME']?>',
                'sku': '<?=$auto?>',
                'category': 'Car',
                'price': '<?=$res/$rent?>',
                'quantity': '<?=$rent?>',
                'currency': 'RUB' // local currency code.
            });
            ga('ecommerce:send');
            */


            var products = [];

            products.push(
                {
                    "id": "<?=$car['NAME']?>",
                    "name": "<?=$car['NAME']?>",
                    "price": <?=$res/$rent?>,
                    "quantity" : '<?=$rent?>',
                    'category': 'Car',
                }
            ); 

            ga('ecommerce:addItem', {
                'id': '<?=$order['ID']?>',                     // Transaction ID. Required.
                'name': '<?=$car['NAME']?>',    // Product name. Required.
                'sku': '<?=$auto?>',                 // SKU/code.
                'category': 'Car',         // Category or variation.
                'price': '<?=$res/$rent?>',                 // Unit price.
                'quantity': '<?=$rent?>',                   // Quantity.
            });

            ga('ecommerce:send');
            dataLayer.push({
                "ecommerce": {
                    "purchase": {
                        "actionField": {
                            "id" : "<?=$order['ID']?>"
                        },
                        "products": products
                    }
                }
            });

        </script>
        <?=$name?>, Вы оформили заявку №<?=$order['ID']?> на аренду автомобиля <?=$car['NAME']?><?if ($rent != 0){?> сроком на <?=$rent?> суток, стоимость <?=$res?> руб. (<?=$res/$rent?> руб/суток). <?}else{?>.<?}?> 
        <?if ($email != null){?>На адрес <?=$email?> отправлена информация с детализацией вашей заявки.<?}?>
        В ближайшее время с вами свяжется сотрудник нашей компании и обсудит с вами детали, вы так же можете позвонить самостоятельно по бесплатному номеру 8(800)777 59 90.
        <?}?>
</div>   
<div>
    <?$APPLICATION->IncludeComponent(
            "webgk:car.list", 
            ".default", 
            array(
                "CAR" => array(
                ),
                "TYPE_SORT" => "ID",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>
</div>
<?$_SESSION['id']=1;
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
 