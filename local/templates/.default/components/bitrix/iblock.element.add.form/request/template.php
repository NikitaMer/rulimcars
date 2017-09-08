<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);
$_SESSION['id']=0;
$dbCity = CIBlockSection::GetList(array(), array("IBLOCK_ID" => CITY_ID,'ACTIVE' => 'Y'));
     
?><script>
/*$(document).ready(function () {        
    var car = {
        '0' : {
          'Name' : false,  
          'Year' : false,  
          'Day' : [false,''],  
          'Price' : false,  
        },    
    <?foreach ($arResult['ALL_CAR'] as $key=>$car){?>
    '<?=$key?>' : {
        'Name' : '<?=$car['NAME']?>',
        'Year' : '<?=$car['PROPERTIES']['YEAR_CAR']?>',
        'Day' : [<?foreach($car['PRICE'] as $day){?>
            '<?=$day['QUANTITY_FROM']?>',
            '<?=$day['QUANTITY_TO']?>',       
        <?}?>],
        'Price' : [<?foreach($car['PRICE'] as $price){?>
            '<?=stristr($price['PRICE'], '.', true)?>',       
        <?}?>],   
    },
    <?}?>};
    <?if ($arResult['RES_CAR']['ID'] != null){?>
        presentcar = <?=$arResult['RES_CAR']['ID']?>;
        PresentCar(car[presentcar]['Name'], car[presentcar]['Year'], presentcar, car[presentcar]['Price'][0]);
    <?}else{?>
        presentcar = false;
    <?}?>    
    $("#select").change(function(){
        newcarid = $('#select option:selected').attr('value'); 
        src = $('#select option:selected').attr('data_path');        
        $('#selectimg').find('img').attr("src",$('#select option:selected').attr('data_path'));
        $("#rent").change();
        ChangeCar(newcarid, car[newcarid]['Name'], car[newcarid]['Year'], car[newcarid]['Price'][0], oldcarid, car[oldcarid]['Name'], car[oldcarid]['Year'], car[oldcarid]['Price'][0]);       
    });
    if (presentcar == false){
        $('#rentday').find('a').text("Выберите автомобиль");
        $('#rentday').find('a').css("color" , "#e93f45");  
        $('#rentres').find('a').text("Выберите срок аренды");
        $('#result').val('');     
    }else{
        present_selprice = car[presentcar]['Price'];        
        $('#rentday').find('a').text("от "+present_selprice[present_selprice.length-1]+" до "+present_selprice[0]);
        $('#rentday').find('a').css("color" , "#5d5d5d");  
        $('#rentres').find('a').text("Выберите срок аренды");   
        $('#result').val('');
    }    
    $("#rent").change(function(){        
        if(($("#select").val() == "0" && $("#rent").val() == "0") || $("#select").val() == "0"){
           $('#rentday').find('a').text("Выберите автомобиль");
           $('#rentday').find('a').css("color" , "#e93f45");  
           $('#rentres').find('a').text("Выберите срок аренды");   
           $('#result').val('');   
        }else if ($("#rent").val() == "0"){
           selprice = car[$('#select option:selected').attr('value')]['Price'];            
           $('#rentday').find('a').text("от "+selprice[selprice.length-1]+" до "+selprice[0]);
           $('#rentday').find('a').css("color" , "#5d5d5d");
           $('#rentres').find('a').text("Выберите срок аренды");   
           $('#result').val(''); 
        }else{
            var i;
            selday = car[$('#select option:selected').attr('value')]['Day'];   
            selprice = car[$('#select option:selected').attr('value')]['Price'];
            $('#rentday').find('a').css("color" , "#5d5d5d");    
            for (i = 0; i<=selday.length-1 ; i+=2) {            
                if (selday[selday.length-2]<=Number($("#rent").val())){                
                    $('#rentday').find('a').text(selprice[selprice.length-1]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text($("#rent").val()*selprice[selprice.length-1]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val($("#rent").val()*selprice[selprice.length-1]);
                    i = 0;                    
                    break;    
                }           
                if (selday[i] <= Number($("#rent").val()) && selday[i+1] >= Number($("#rent").val())){
                    $('#rentday').find('a').text(selprice[i/2]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text($("#rent").val()*selprice[i/2]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val($("#rent").val()*selprice[i/2]);
                    i = 0;                    
                    break;    
                }
            }
        }                                               
    });
});*/
</script>                    
<div class="form">
    <div class="form-block-1">
        <div class="form-block-1-1">
            <div class="form-block-1-1-1">
                <div class="cost">
                    <p><?=GetMessage("COST")?></p>                    
                    <div class="day" id="rentday"><?=GetMessage("DAY")?><a></a></div>      
                    <div class="result" id="rentres"><?=GetMessage("RESULT")?><a></a></div>              
                </div>        
            </div>
        </div>
        <div class="form-block-1-2"> 
            <div class="car_rent" id="selectimg">
            <img src="<?=CFile::GetPath($arResult['RES_CAR']['PREVIEW_PICTURE'])?>" alt=""/>         
            </div>
        </div>
        <div class="form-block-1-3">
            <div class="text"><?=GetMessage("FINAL_PRICE")?></div>
        </div>
    </div>
    <div class="form-block-2">
        <div class="form-block-2-1">        
            <button type="submit" class="button1 button button_text_mini" id="order_footrequest"><?=GetMessage("SEND_REQUEST")?></button>
            <form method="post" action="/rent/thankyou.php" class="rentpost">
                <p><?=GetMessage("PERSONAL_DATA")?></p>        
                <label>
                       <select class="select" name="YEAR" id="select_city">
                        <option value="0"><?=GetMessage("PLACE_CITY")?></option>
                        <?while ($arCity = $dbCity->GetNext()) {?>
                            <option value="<?=$arCity["ID"]?>">
                                <?=$arCity["NAME"]?> 
                            </option>        
                        <?}?>
                       </select>
                </label>
                <label>
                       <select class="select must" name="TYPE_RENT" id="select_type_rent">
                        <option value="0"><?=GetMessage("PLACE_TYPE_RENT")?></option>
                        <option value="TRANSFER"><?=GetMessage("TRANSFER")?></option>        
                        <option value="WITH_DRIVER"><?=GetMessage("WITH_DRIVER")?></option>        
                        <option value="WITHOUT_DRIVER"><?=GetMessage("WITHOUT_DRIVER")?></option>        
                       </select>
                </label>        
                <label>
                       <select class="select must" name="AUTO" id="select_car">
                        <option value="0" data_path=""><?=GetMessage("CAR")?></option>
                        <?foreach ($arResult['ALL_CAR'] as $car): 
                            if ($car['PROPERTIES']['SHOW_CAR'] == 13){?>
                            <option <?if ($car['ID'] == $arResult['RES_CAR']['ID']): ?>selected="selected"<? endif;?> data_path="<?=CFile::GetPath($car['PREVIEW_PICTURE'])?>" 
                                value="<?=$car["ID"]?>">
                                <?=$car["NAME"]?> <?=$car['PROPERTIES']['YEAR_CAR']?>
                            </option>
                        <?}endforeach;?>
                       </select>
                </label>
                <label><input autocomplete="off" type="text" class="input must" id="name" name="NAME" placeholder="<?=GetMessage("PLACE_NAME")?>" value=""></label>
                <label><input autocomplete="off" type="text" class="input" id="email" name="EMAIL" placeholder="<?=GetMessage("PLACE_EMAIL")?>" value=""></label>
                <label><input autocomplete="off" type="text" class="input must" id="phone" name="PHONE" placeholder="<?=GetMessage("PLACE_PHONE")?>" value=""></label>
                <div class="transfer">
                    
                </div>
                <div class="with_driver">
                    <label><?$APPLICATION->IncludeComponent(
                                "bitrix:main.calendar", 
                                "calendar_rent_delivery", 
                                array(
                                    "SHOW_INPUT" => "Y",
                                    "FORM_NAME" => "",
                                    "INPUT_NAME" => "WITH_DATE_DELIVERY",
                                    "INPUT_VALUE" => "",
                                    "INPUT_VALUE_FINISH" => "",
                                    "SHOW_TIME" => "Y",
                                    "HIDE_TIMEBAR" => "N",
                                    "COMPONENT_TEMPLATE" => "calendar_rent_delivery",
                                    "INPUT_NAME_FINISH" => "",    
                                ),
                                false
                            );
                            ?></label>
                    <label><?$APPLICATION->IncludeComponent(
                                "bitrix:main.calendar", 
                                "calendar_rent_return", 
                                array(
                                    "SHOW_INPUT" => "Y",
                                    "FORM_NAME" => "",
                                    "INPUT_NAME" => "WITH_DATE_RETURN",
                                    "INPUT_VALUE" => "",
                                    "INPUT_VALUE_FINISH" => "",
                                    "SHOW_TIME" => "Y",
                                    "HIDE_TIMEBAR" => "N",
                                    "COMPONENT_TEMPLATE" => "calendar_rent_return",
                                    "INPUT_NAME_FINISH" => "",    
                                ),
                                false
                            );
                            ?></label>
                    <label><input autocomplete="on" type="text" class="address_delivery" id="name" name="ADDRESS_DELIVERY" placeholder="<?=GetMessage("ADDRESS_DELIVERY")?>" value="" disabled="disabled"></label>
                    <label><input autocomplete="on" type="text" class="address_return" id="name" name="ADDRESS_RETURN" placeholder="<?=GetMessage("ADDRESS_RETURN")?>" value="" disabled="disabled"></label>
                </div>
                <div class="without_driver">
                    <label><?$APPLICATION->IncludeComponent(
                                "bitrix:main.calendar", 
                                "calendar_rent_delivery", 
                                array(
                                    "SHOW_INPUT" => "Y",
                                    "FORM_NAME" => "",
                                    "INPUT_NAME" => "WITHOUT_DATE_DELIVERY",
                                    "INPUT_VALUE" => "",
                                    "INPUT_VALUE_FINISH" => "",
                                    "SHOW_TIME" => "N",
                                    "HIDE_TIMEBAR" => "N",
                                    "COMPONENT_TEMPLATE" => "calendar_rent_delivery",
                                    "INPUT_NAME_FINISH" => "",    
                                ),
                                false
                            );
                            ?></label>
                    <label><?$APPLICATION->IncludeComponent(
                                "bitrix:main.calendar", 
                                "calendar_rent_return", 
                                array(
                                    "SHOW_INPUT" => "Y",
                                    "FORM_NAME" => "",
                                    "INPUT_NAME" => "WITHOUT_DATE_RETURN",
                                    "INPUT_VALUE" => "",
                                    "INPUT_VALUE_FINISH" => "",
                                    "SHOW_TIME" => "N",
                                    "HIDE_TIMEBAR" => "N",
                                    "COMPONENT_TEMPLATE" => "calendar_rent_return",
                                    "INPUT_NAME_FINISH" => "",    
                                ),
                                false
                            );
                            ?></label>
                    <label><select class="select" name="CAR_PLACE_DELIVERY" id="select_car_place_delivery" disabled="disabled">
                        <option value=""><?=GetMessage("PLACE_CAR_PLACE_DELIVERY")?></option>
                        <option value="address"><?=GetMessage("PLACE_CAR_PLACE_ADDRESS_DELIVERY")?></option>        
                    </select></label>
                    <label style="display: none;"><input autocomplete="on" type="text" class="address_delivery" id="name" name="ADDRESS_DELIVERY" placeholder="<?=GetMessage("ADDRESS_DELIVERY")?>" value="" disabled="disabled"></label>
                    <label><select class="select" name="CAR_PLACE_RETURN" id="select_car_place_return" disabled="disabled">
                        <option value=""><?=GetMessage("PLACE_CAR_PLACE_RETURN")?></option>
                        <option value="address"><?=GetMessage("PLACE_CAR_PLACE_ADDRESS_RETURN")?></option>       
                    </select></label>
                    <label style="display: none;"><input autocomplete="on" type="text" class="address_return" id="name" name="ADDRESS_RETURN" placeholder="<?=GetMessage("ADDRESS_RETURN")?>" value="" disabled="disabled"></label>
                </div>        
                <!--label><select id="rent" class="input rent" name="RENT">
                         <option value="0"><?=GetMessage("LEASE")?></option>
                         <option value="1"><?=GetMessage("1_DAY")?></option>
                         <option value="2"><?=GetMessage("2_DAY")?></option>
                         <option value="3"><?=GetMessage("3_DAY")?></option>
                         <option value="4"><?=GetMessage("4_DAY")?></option>
                         <option value="5"><?=GetMessage("5_DAY")?></option>
                         <option value="6"><?=GetMessage("6_DAY")?></option>
                         <option value="7"><?=GetMessage("7_DAY")?></option>
                         <option value="8"><?=GetMessage("8_DAY")?></option>
                         <option value="9"><?=GetMessage("9_DAY")?></option>
                         <option value="10"><?=GetMessage("10_DAY")?></option>
                         <option value="11"><?=GetMessage("11_DAY")?></option>
                         <option value="12"><?=GetMessage("12_DAY")?></option>
                         <option value="13"><?=GetMessage("13_DAY")?></option>
                         <option value="14"><?=GetMessage("14_DAY")?></option>
                         <option value="15"><?=GetMessage("15_DAY")?></option>
                         <option value="16"><?=GetMessage("16_DAY")?></option>
                         <option value="17"><?=GetMessage("17_DAY")?></option>
                         <option value="18"><?=GetMessage("18_DAY")?></option>
                         <option value="19"><?=GetMessage("19_DAY")?></option>
                         <option value="20"><?=GetMessage("20_DAY")?></option>
                         <option value="21"><?=GetMessage("21_DAY")?></option>
                         <option value="22"><?=GetMessage("22_DAY")?></option>
                         <option value="23"><?=GetMessage("23_DAY")?></option>
                         <option value="24"><?=GetMessage("24_DAY")?></option>
                         <option value="25"><?=GetMessage("25_DAY")?></option>
                         <option value="26"><?=GetMessage("26_DAY")?></option>
                         <option value="27"><?=GetMessage("27_DAY")?></option>
                         <option value="28"><?=GetMessage("28_DAY")?></option>
                         <option value="29"><?=GetMessage("29_DAY")?></option>
                         <option value="30"><?=GetMessage("30_DAY")?></option>
                         <option value="31"><?=GetMessage("1_MONTH")?></option>                           
                       </select>
                </label-->
                <label><textarea class="textarea" id="text" placeholder="<?=GetMessage("PLACE_COMMENT")?>" name="TEXT"></textarea></label>
                <label class="invisible"><input autocomplete="off" type="text" id="result" class="input invisible" name="RESULT" placeholder="<?=GetMessage("PLACE_RESULT")?>" value="0"/></label>                            
            </form>
        </div>
        <div class="form-block-2-2">
            <button type="submit" class="button button_text_mini" id="order_footrequest"><?=GetMessage("SEND_REQUEST")?></button>
        </div>
    </div>
    <div class="horizontalgrey horizontalgrey2"></div>               
</div> 