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
     
?>                   
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
                        <option class="option_transfer" value="Трансфер"><?=GetMessage("TRANSFER")?></option>        
                        <option class="option_with_driver" value="С водителем"><?=GetMessage("WITH_DRIVER")?></option>        
                        <option class="option_without_driver" value="Без водителя"><?=GetMessage("WITHOUT_DRIVER")?></option>        
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
                    <label>
                       <select class="select must half" name="DIRECTION_AIRPORT" id="direction_select_airport" disabled="disabled">
                        <option value="IN"><?=GetMessage("IN_AIRPORT")?></option>
                        <option value="OUT"><?=GetMessage("OUT_AIRPORT")?></option>
                       </select>
                    </label>
                    <div class="section_date">
                        <label><?$APPLICATION->IncludeComponent(
                                    "bitrix:main.calendar", 
                                    "calendar_rent_delivery", 
                                    array(
                                        "SHOW_INPUT" => "Y",
                                        "FORM_NAME" => "",
                                        "INPUT_NAME" => "TRANSFER_DATE_DELIVERY",
                                        "INPUT_VALUE" => "",
                                        "INPUT_VALUE_FINISH" => "",
                                        "SHOW_TIME" => "Y",
                                        "HIDE_TIMEBAR" => "N",
                                        "COMPONENT_TEMPLATE" => "calendar_rent_delivery",
                                        "INPUT_NAME_FINISH" => "",
                                        "INPUT_CLASS" => "transfer must"    
                                    ),
                                    false
                                );
                                ?></label>
                     </div>
                     <label>
                       <select class="select must" name="AIRPORT" id="select_airport" disabled="disabled">
                        <option value="0"><?=GetMessage("AIRPORT")?></option>  
                       </select>
                    </label>
                     <label><input autocomplete="on" type="text" class="address_transfer" id="address_transfer" name="TRANSFER" placeholder="<?=GetMessage("ADDRESS_DEPARTURE")?>" value="" disabled="disabled"></label>     
                </div>
                <div class="with_driver">
                    <div class="section_date">
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
                                        "INPUT_CLASS" => "with must"    
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
                                        "INPUT_CLASS" => "with must"    
                                    ),
                                    false
                                );
                                ?></label>
                    </div>
                    <label><input autocomplete="on" type="text" class="address_delivery_with_driver" id="address_delivery" name="ADDRESS_DELIVERY" placeholder="<?=GetMessage("ADDRESS_DELIVERY")?>" value="" disabled="disabled"></label>
                    <label><input autocomplete="on" type="text" class="address_return_with_driver" id="address_return" name="ADDRESS_RETURN" placeholder="<?=GetMessage("ADDRESS_RETURN")?>" value="" disabled="disabled"></label>
                </div>
                <div class="without_driver">
                    <div class="section_date">
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
                                        "INPUT_CLASS" => "without must"    
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
                                        "INPUT_CLASS" => "without must"    
                                    ),
                                    false
                                );
                                ?></label>
                    </div>
                    <label><select class="select must" name="CAR_PLACE_DELIVERY" id="select_car_place_delivery" disabled="disabled">
                        <option value=""><?=GetMessage("PLACE_CAR_PLACE_DELIVERY")?></option>
                        <option value="address"><?=GetMessage("PLACE_CAR_PLACE_ADDRESS_DELIVERY")?></option>        
                    </select></label>
                    <label style="display: none;"><input autocomplete="on" type="text" class="address_delivery_without_driver" id="address_delivery_without_driver" name="ADDRESS_DELIVERY" placeholder="<?=GetMessage("ADDRESS_DELIVERY")?>" value="" disabled="disabled"></label>
                    <label><select class="select must" name="CAR_PLACE_RETURN" id="select_car_place_return" disabled="disabled">
                        <option value=""><?=GetMessage("PLACE_CAR_PLACE_RETURN")?></option>
                        <option value="address"><?=GetMessage("PLACE_CAR_PLACE_ADDRESS_RETURN")?></option>       
                    </select></label>
                    <label style="display: none;"><input autocomplete="on" type="text" class="address_return_without_driver" id="address_return_without_driver" name="ADDRESS_RETURN" placeholder="<?=GetMessage("ADDRESS_RETURN")?>" value="" disabled="disabled"></label>
                </div>        
                
                <label><textarea class="textarea" id="comment" placeholder="<?=GetMessage("PLACE_COMMENT")?>" name="TEXT"></textarea></label>
                <label class="invisible"><input autocomplete="off" type="text" id="result" class="input invisible" name="RESULT" placeholder="<?=GetMessage("PLACE_RESULT")?>" value="0"/></label>                            
                <label class="invisible"><input autocomplete="off" type="text" id="days" class="input invisible" name="DAYS" placeholder="<?=GetMessage("PLACE_DAY")?>" value="0"/></label>                            
            </form>
        </div>
        <div class="form-block-2-2">
            <button type="submit" class="button button_text_mini" id="order_footrequest"><?=GetMessage("SEND_REQUEST")?></button>
        </div>
    </div>
    <div class="horizontalgrey horizontalgrey2"></div>               
</div> 