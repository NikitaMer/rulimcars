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
    $rent = $_POST["DAYS"];
    $date_delivery = $_POST["WITH_DATE_DELIVERY"] ? $_POST["WITH_DATE_DELIVERY"] : $_POST["WITHOUT_DATE_DELIVERY"];
    $address_delivery = $_POST["ADDRESS_DELIVERY"];
    $date_return = $_POST["WITH_DATE_RETURN"] ? $_POST["WITH_DATE_RETURN"] : $_POST["WITHOUT_DATE_RETURN"];
    $address_return = $_POST["ADDRESS_RETURN"];
    $orderId =  $_POST["ORDERID"];
    
if ($name != null && $phone != null && $auto != null){  
    
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

    <?=$name?>, Вы оформили заявку №<?=$orderId?> на аренду автомобиля <?=$car['NAME']?><?if ($rent != 0){?> сроком на <?=$rent?> , стоимость <?=$res?> руб. (<?=$res/$rent?> руб/суток). <?}else{?>.<?}?> 
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
 