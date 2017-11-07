<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
    function NewRandUser($n, $e, $p) {
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
            "NAME"              => $n,
            "EMAIL"             => $e,
            "LOGIN"             => $n.$rnd,
            "PERSONAL_PHONE"    => $p,
            "LID"               => SITE_ID,
            "ACTIVE"            => "Y",
            "GROUP_ID"          => array(CLIENT_GROUP_ID),
            "PASSWORD"          => $pass,
            "CONFIRM_PASSWORD"  => $pass,
        );
        $user_ID = $user->Add($arFields);
        
        return  $user_ID;
    }
        
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("sale");
    CModule::IncludeModule("statistic");
    CModule::IncludeModule("catalog");
    
    $city = $_POST['city']; 
    $type_rent = $_POST['type_rent'];
    $airport = $_POST['airport'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];
    $date_delivery = $_POST['date_delivery'];
    $date_return = $_POST['date_return'];
    $address_transfer = $_POST['address_transfer'];
    $direction_airport = $_POST['direction_airport'];
    $address_delivery = $_POST['addres_delivery'];
    $address_return = $_POST['addres_return'];
    $res =  $_POST["result"];                                        
    $newcar = $_POST['new_car'];
    $oldcar = $_POST['old_car'];
    
    $button = $_POST['button'];
    
    
    $CIBE = new CIBlockElement;
    $arResult["ERROR"] = false;
    
    // Считаем колличество дней/часов
    if ($date_return && $date_delivery) {
        $rent_time = intval(abs(strtotime($date_return) - strtotime($date_delivery)));
    }
    // Проверяем дни это или часы
    if ($rent_time >= 86400) {     // Аренда на больше чем на сутки.
       $rent_time = floor($rent_time / (3600 * 24));   // Получаем количество дней
       $arResult["RENTDAY"] = "Сутки:<a></a>"; 
       $type = "За сутки"; 
       $text_days = morpher($rent_time, "день", "дня", "дней");  
    } else if ($rent_time < 86400 && $rent_time != 0) {
       $rent_time = floor($rent_time / 3600);     // Получаем количество часов
       $arResult["RENTDAY"] = "Часов:<a></a>"; 
       $type = "За час";
       $text_days = morpher($rent_time, "час", "часа", "часов");
    } else {
       $arResult["RENTDAY"] = "Сутки:<a></a>"; 
    } 
    if ($type_rent == 'Трансфер') {
       $arResult["RENTDAY"] = "Трансфер:<a></a>";
       $type = "Трансфер";
       $text_days = "Трансфер"; 
    }
    
    // Если автомобиль выбран то возвращаем его название и год. Нужно для google аналитики. 
    if ($newcar) {
        $result_newcar = $CIBE->GetList(array(), array("ID" => $newcar), false, false, array("ID","NAME", "IBLOCK_ID", "PROPERTY_YEAR_CAR", "DETAIL_PAGE_URL", "DETAIL_PICTURE"))->GetNext();
        
        $arResult["NEW_CAR"]["YEAR"] = $result_newcar["PROPERTY_YEAR_CAR_VALUE"];
        $arResult["NEW_CAR"]["NAME"] = $result_newcar["NAME"];
        $detail_page = $result_newcar["DETAIL_PAGE_URL"];
        $detail_picture = $result_newcar["DETAIL_PICTURE"];
                
    } else {
        $arResult["RENTDAY_IN_A"] = "Выберите автомобиль";
        $arResult["RENTDAY_RED"] = true;
        $arResult["RENTRES_IN_A"] = "Выберите автомобиль";    
    }
    
    // Создаем список автомобилей, офисов и аэропортов
    if($city != 0){
        $rsCar = $CIBE->GetList(array(),array('IBLOCK_ID' => 12, 'PROPERTY_CITY' => $city, 'PROPERTY_SHOW_CAR' => 13), false, false, array("ID","NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));
        $rsOffice = $CIBE->GetList(array(),array('IBLOCK_ID' => 19, 'IBLOCK_SECTION_ID' => $city, 'PROPERTY_TYPE_BUILDING' => 22), false, false, array("ID","NAME", "PROPERTY_TYPE_BUILDING"));            
        $rsAirport = $CIBE->GetList(array(),array('IBLOCK_ID' => 19, 'IBLOCK_SECTION_ID' => $city, 'PROPERTY_TYPE_BUILDING' => 23), false, false, array("ID","NAME", "PROPERTY_TYPE_BUILDING"));            
    }else{
        $rsCar = $CIBE->GetList(array(),array('IBLOCK_ID' => 12, 'PROPERTY_SHOW_CAR' => 13), false, false, array("ID","NAME", "PROPERTY_YEAR_CAR", "PREVIEW_PICTURE"));
        $arResult["RENTDAY_IN_A"] = "Выберите город";
        $arResult["RENTDAY_RED"] = true;
        $arResult["RENTRES_IN_A"] = "Выберите город";                   
    }    
    while ($arCar = $rsCar->GetNext()) {
        $arResult["CAR"] .= "<option data_path=\"".CFile::GetPath($arCar['PREVIEW_PICTURE'])."\" value=\"".$arCar["ID"]."\">
                        ".$arCar["NAME"]." ".$arCar['PROPERTY_YEAR_CAR_VALUE']."
                    </option>";                                                           
    }
    if($rsOffice){
        while ($arOffice = $rsOffice->GetNext()) {
            $arResult["OFFICE"] .= "<option value=\"".$arOffice["ID"]."\">".$arOffice["NAME"]." </option>";                                                           
        }    
    }
    if($rsAirport){
        while ($arAirport = $rsAirport->GetNext()) {
            $arResult["AIRPORT"] .= "<option value=\"".$arAirport["ID"]."\">".$arAirport["NAME"]." </option>";                                                           
        }    
    }    
    
    // Берем нужную нам торговые предложения  
    $Offer = array();          
    if ($type_rent && $type) {
        if ($type_rent == "Трансфер") {
            if ($airport != 0) {
                $Filter = array('IBLOCK_ID' => TRADE_OFFERS, 'PROPERTY_CML2_LINK' => $newcar, 'PROPERTY_TYPE_RENT_VALUE' => $type_rent, 'PROPERTY_TYPE_PRICE_VALUE' => $type, 'PROPERTY_AIRPORT' => $airport);             
                $rsOffers = $CIBE->GetList(array(), $Filter, false, false, array("ID","NAME", "PROPERTY_TYPE_RENT", "PROPERTY_TYPE_PRICE")); 
                while ($arOffer = $rsOffers->GetNext()) {                                  
                    array_push($Offer, $arOffer["ID"]);
                    $offer_name = $arOffer["NAME"];             
                    $offer_id = $arOffer["ID"];             
                }   
            } else {
                $arResult["RENTDAY_IN_A"] = "Выберите аэропорт";
                $arResult["RENTDAY_RED"] = true;
                $arResult["RENTRES_IN_A"] = "Выберите аэропорт"; 
            }                
        } else {                              
            $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => TRADE_OFFERS, 'PROPERTY_CML2_LINK' => $newcar, 'PROPERTY_TYPE_RENT_VALUE' => $type_rent, 'PROPERTY_TYPE_PRICE_VALUE' => $type), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT", "PROPERTY_TYPE_PRICE")); 
            while ($arOffer = $rsOffers->GetNext()) {                                  
                array_push($Offer, $arOffer["ID"]); 
                $offer_name = $arOffer["NAME"];             
                $offer_id = $arOffer["ID"];            
            }    
        }           
    } else if ($type_rent && !$type) {                          
        $rsOffers = $CIBE->GetList(array(),array('IBLOCK_ID' => TRADE_OFFERS, 'PROPERTY_CML2_LINK' => $newcar, 'PROPERTY_TYPE_RENT_VALUE' => $type_rent), false, false, array("ID","NAME", "PROPERTY_TYPE_RENT", "PROPERTY_TYPE_PRICE")); 
        while ($arOffer = $rsOffers->GetNext()) {                                  
            array_push($Offer, $arOffer["ID"]);                          
        }
        $arResult["RENTRES_IN_A"] = "Выберите дату возврата и подачи";   
    } else if (!$type_rent) {
        $arResult["RENTDAY_IN_A"] = "Выберите тип аренды";
        $arResult["RENTDAY_RED"] = true;
        $arResult["RENTRES_IN_A"] = "Выберите тип аренды";    
    }
    
    
    // Берем цены торговых предложений
    if($Offer){
        if ($type_rent == "Трансфер") {
            $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => TRADE_OFFERS,"PRODUCT_ID" => $Offer));
            while ($arPrice = $rsPrice->Fetch()) {    
                $arResult["PRICE_IN_DAY"] = "от ".stristr($arPrice["PRICE"], '.', true);
                $arResult["PRICE_RES"] = "от ".stristr($arPrice["PRICE"], '.', true);
                $arResult["RESULT"] = stristr($arPrice["PRICE"], '.', true);
            }
            $arResult["DAYS"] = $text_days;
            $rent_time = 1; // Нужно для оформления заказа
        } else if($date_return && $date_delivery && $rent_time){
            $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => TRADE_OFFERS,"PRODUCT_ID" => $Offer, "<=QUANTITY_FROM" => $rent_time, ">=QUANTITY_TO" => $rent_time));
            while ($arPrice = $rsPrice->Fetch()) {    
                $arResult["PRICE_IN_DAY"] = stristr($arPrice["PRICE"], '.', true);
                $arResult["PRICE_RES"] = $arResult["PRICE_IN_DAY"]*$rent_time;
                $arResult["RESULT"] = $arResult["PRICE_RES"];      
            }
            $arResult["DAYS"] = $rent_time." ".$text_days;      
        } else  {
            $rsPrice = CPrice::GetList(array(), array("IBLOCK_ID" => TRADE_OFFERS,"PRODUCT_ID" => $Offer));
            while ($arPrice = $rsPrice->Fetch()) {                             
                $Prices[] = stristr($arPrice["PRICE"], '.', true);                
            }       
            $min = min($Prices); $max = max($Prices); 
            $arResult["PRICE_IN_DAY"] = "от ".$min." до ".$max;
        }   
    }
    
    if (!$city && !$type_rent) {
        $arResult["RENTDAY_IN_A"] = "Выберите город и тип аренды";
        $arResult["RENTDAY_RED"] = true;
        $arResult["RENTRES_IN_A"] = "Выберите город и тип аренды";       
    }
    
    // Если произошла какая то пижня.
    if (!$arResult["PRICE_IN_DAY"] && !$arResult["RENTRES_IN_A"]) {
        $arResult["ERROR"] = true;            
    } 
    
    // Создание заказа в админке.
    if ($button && !$arResult["ERROR"] && $res) {  
        $arAir = CIBlockElement::GetList(array("sort"=>"asc"), array("ID" => $airport))->GetNext();
        $arCity = CIBlockSection::GetList(array("sort"=>"asc"), array("ID" => $city))->GetNext();
        if ($direction_airport == "IN") {
            $direction_airport = "В аэропорт";    
        } else if ($direction_airport == "OUT") {
            $direction_airport = "Из аэропорта";    
        }
        $product = array(
            'ID' => $offer_id, 
            'NAME' => $offer_name, 
            'PRICE' => $arResult["RESULT"]/$rent_time, 
            'CURRENCY' => 'RUB', 
            'QUANTITY' => $rent_time,    
        );

        $user = NewRandUser($name, $email, $phone);
        $basket = Bitrix\Sale\Basket::create(SITE_ID);
        $item = $basket->createItem("catalog", $product['ID']);
        unset($product["ID"]);
        $item->setFields($product);
        $order = Bitrix\Sale\Order::create(SITE_ID, $user);
        $order->setPersonTypeId(CLIENT_GROUP_ID);
        $order->setBasket($basket);
        $order->setField('USER_DESCRIPTION', $comment);

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
        if ($name){$somePropValueName = $propertyCollection->getItemByOrderPropertyId(1)->setValue($name);}
        if ($phone){$somePropValuePhone = $propertyCollection->getItemByOrderPropertyId(2)->setValue($phone);}
        if ($email){$somePropValueEmail = $propertyCollection->getItemByOrderPropertyId(3)->setValue($email);}
        if ($date_delivery){$somePropValueDateD = $propertyCollection->getItemByOrderPropertyId(6)->setValue($date_delivery);}
        if ($address_delivery){$somePropValueAddressD = $propertyCollection->getItemByOrderPropertyId(4)->setValue($address_delivery);}
        if ($date_return){$somePropValueDateR = $propertyCollection->getItemByOrderPropertyId(7)->setValue($date_return);}
        if ($address_return){$somePropValueAddressR = $propertyCollection->getItemByOrderPropertyId(5)->setValue($address_return);}
        if ($city){$somePropValueCity = $propertyCollection->getItemByOrderPropertyId(8)->setValue($arCity["NAME"]);}
        if ($type_rent){$somePropValueTypeRent = $propertyCollection->getItemByOrderPropertyId(9)->setValue($type_rent);}
        if ($direction_airport && $address_transfer){$somePropValueDirectionAir = $propertyCollection->getItemByOrderPropertyId(10)->setValue($direction_airport);}
        if ($arAir){$somePropValueAirport = $propertyCollection->getItemByOrderPropertyId(11)->setValue($arAir["NAME"]);}
        if ($address_transfer){$somePropValueAddressT = $propertyCollection->getItemByOrderPropertyId(12)->setValue($address_transfer);}
        $result = $order->save();  
        $orderId = $order->getId();
        $arResult["ORDER_ID"] = $orderId;                 
    }
    
    // отправка письма клиенту
    if ($arResult["ORDER_ID"]) { 
        $arCarProp = CIBlockElement::GetByID($newcar)->GetNextElement()->GetProperties();
        $arMailFields = array(
            'NAME' => $name,
            'ID' => $arResult["ORDER_ID"],
            'DATA' => $date_delivery,
            'RENT' => $rent_time,
            'RESULT' => $arResult["RESULT"],
            'EMAIL' => $email,
            'PHONE' => $phone,
            'RESULT_DAY' => $arResult["PRICE_IN_DAY"],
            'COMMENT' => $comment,
            'NAME_CAR' => $arResult["NEW_CAR"]["NAME"],
            'YEAR_CAR' => $arResult["NEW_CAR"]["YEAR"],
            'DETAIL_CAR' => $detail_page,
            'TYPE_CAR_CIR' => $arCarProp['TYPE_CAR_CIR']['VALUE'],
            'TYPE_CAR_LAT' => $arCarProp['TYPE_CAR_CIR']['DESCRIPTION'],
            'CAR_PICTURE' => "http://".$_SERVER['HTTP_HOST'].CFile::GetPath($detail_picture),
            'DATE_CREATE' => $order->getField("DATE_UPDATE"),
        );
        if($arMailFields['RENT'] == 0 ) {
            CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", EMAIL_WITHOUT_RENT_ID);
        }else{
            CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields,"Y", EMAIL_WITH_RENT_ID);
        }
    }
          
       
    
    echo json_encode($arResult);