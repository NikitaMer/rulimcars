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
    if ($_SESSION['id'] != 1 ){
        // Формирование корзины и создание заказа
        $car_catolog = CIBlockElement::GetProperty(12, $auto, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->Fetch();        
        $catolog = GetIBlockElement($car_catolog['VALUE']);     
        $product = array(
            'ID' => $car_catolog['VALUE'], 
            'NAME' => $catolog['NAME'], 
            'PRICE' => $res/$rent, 
            'CURRENCY' => 'RUB', 
            'QUANTITY' => $rent,    
        );
        // Генерируем случайный пароль
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
        // Так как заказ нужно привязывать к пользователю. Но регистрации на сайте нет. Поэтому выкручиваемся как можем.
        $user = new CUser;
        $rnd = substr($pass,0,-3);
        if($email == null){$email = "noemail@rulimcars.ru";}
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
        $orderId = $order->getId();     
        
        // Добавляем заявку в инфоблок "Заявки"
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
        $PROP["ID_ORDER"] = $orderId;         
        $arLoadProductArray = Array(
            "IBLOCK_SECTION_ID" => false,        
            "IBLOCK_ID"      => 10,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $name,
            "ACTIVE"         => "Y",          
            "DETAIL_TEXT"    => $text,
        );         
        $IDiblock = $el->Add($arLoadProductArray);
    }
?>

<div class="content">
    <?$car = GetIBlockElement($auto);?>       
        <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
           'transactionId': '<?=$orderId?>',          //номер заказа             //Итоговая стоимость заявки
           'transactionProducts': [{
               'sku': '<?=$car['CODE']?>',                    //анкор автомобиля (символьный код)
               'name': '<?=$car['NAME']?> <?=$car["PROPERTY"]["YEAR"]["VALUE"]?>',                 //Наименование автомобиля + год
               'price': '<?=$res/$rent?>',                       //стоимость суток аренды
               'quantity': '<?=$rent?>'                           //количество суток аренды
           }]
        });
        </script>
    <script type="text/javascript">     
            //Actionpay
            window.APRT_DATA = {pageType: 6};
            
            var products = [];

            products.push(
                {
                    "id": "<?=$car['NAME']?>",
                    "name": "<?=$car['NAME']?>",
                    "price": "<?=$res/$rent?>",
                    "quantity" : '<?=$rent?>',
                    'category': 'Car',
                }
            ); 
            ga('require', 'ecommerce');
            ga('ecommerce:addTransaction', {
                'id': '<?=$orderId?>',                     // Transaction ID. Required.
                'affiliation': 'Rulimcars',             // Affiliation or store name.
                'revenue': '<?=$res?>',               // Grand Total.
                'shipping': '0',                  // Shipping.
                'tax': '0'                     // Tax.
            });


            ga('ecommerce:addItem', {
                'id': '<?=$orderId?>',
                'name': '<?=$car['NAME']?>',
                'sku': '<?=$auto?>',
                'category': 'Car',
                'price': '<?=$res/$rent?>',
                'quantity': '<?=$rent?>',
                'currency': 'RUB' // local currency code.
            });

            ga('ecommerce:send');
            dataLayer.push({
                "ecommerce": {
                    "purchase": {
                        "actionField": {
                            "id" : "<?=$orderId?>"
                        },
                        "products": products
                    }
                }
            });
    </script>

    <?=$name?>, Вы оформили заявку №<?=$orderId?> на аренду автомобиля <?=$car['NAME']?><?if ($rent != 0){?> сроком на <?=$rent?> суток, стоимость <?=$res?> руб. (<?=$res/$rent?> руб/суток). <?}else{?>.<?}?> 
    <?if ($email != null && $email != "noemail@rulimcars.ru"){?>На адрес <?=$email?> отправлена информация с детализацией вашей заявки.<?}?>
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
<div style="display: none;">
    <?if (isset($orderId) && isset($res) && isset($_COOKIE["utm_source"]) && isset($_COOKIE["utm_medium"])){?>
        <img src="http://www.qxplus.ru/scripts/sale.php?AccountId=109c164e&TotalCost=<?=$res?>&OrderID=<?=$orderId?>&ProductID=rulimcars_default" width="1" height="1" >
    <?}?>
    <?if (isset($_COOKIE["actionpay"])){?>
        <img src="//apypx.com/ok/14885.png?actionpay=<?=$_COOKIE["actionpay"]?>&apid=<?=$orderId?>&price=<?=$res?>" height="1" width="1" />
    <?}?> 
</div>
<?$_SESSION['id'] = 1;  
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
 