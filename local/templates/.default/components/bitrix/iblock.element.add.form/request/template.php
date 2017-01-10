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
if (!empty($arResult["ERRORS"])):?>
    <?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if (strlen($arResult["MESSAGE"]) > 0):?>
    <?ShowNote($arResult["MESSAGE"])?>
<?endif?>
           
            <?$all_res = array();
            foreach ($arResult["PROPERTY_LIST_FULL"] as $propertyID):
            if (gettype($propertyID["ID"]) == string):
                $id = $propertyID["LINK_IBLOCK_ID"];                                
                if ($id == 12):
                    $res_car = array();
                    $result = CIBlockElement::GetList(array(), array("IBLOCK_ID" => $id));                    
                    while ($ob = $result->GetNextElement()){
                        $res = $ob->GetFields();                        
                        array_push($res_car,$res);                                     
                    }    
                endif;        
            endif;
            endforeach;
            // Ищем ID товара с нужным автомобилем
            $c = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17));
            while($c1 = $c->Fetch()){ 
                $ca = CIBlockElement::GetProperty(17, $c1['ID'])->Fetch();
            if ($ca['VALUE'] == $arResult['RES_CAR']['ID']){
                $carID = $c1['ID'];                
            }           
            } 
            // Берем цены из нужного товара
            $CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17)); 
            $dayprice = array(); 
            while($CPrice1 = $CPrice->Fetch()){
            if ($CPrice1['PRODUCT_ID'] == $carID)   
                $dayprice[] = $CPrice1;       
            }
            // Приводим цены в лучший вид 
            $price = array();
            foreach($dayprice as $key){
                $price[] = stristr($key['PRICE'], '.', true);        
            }            
            //my_dump($ar_props);   
            ?>                      
            <div class="form">
                <div>
                    <div class="horizontalgrey horizontalgrey1"></div>
                        <div class="car_rent" id="selectimg">
                            <img src="<?=CFile::GetPath($arResult['RES_CAR']['PREVIEW_PICTURE'])?>" alt=""/>                            
                        </div>                
                    <div class="cost">
                        <p><?=GetMessage("COST")?></p>                    
                        <div class="day" id="rentday"><?=GetMessage("DAY")?><a></a></div>      
                        <div class="result" id="rentres"><?=GetMessage("RESULT")?><a></a></div>              
                    </div>
                    <div class="text"><?=GetMessage("FINAL_PRICE")?></div>
                    </div>
                    <div class="horizontalgrey horizontalgrey3"></div>
                    <div class="verticalgrey"></div>   
                <form method="post" action="/rent/thankyou.php">
                    <button type="submit" class="button1 button" id="smalltext order_headrequest" onclick=""><?=GetMessage("SEND_REQUEST")?></button>
                    <p><?=GetMessage("PERSONAL_DATA")?></p>
                    <label><select class="select must" name="AUTO" id="select">
                            <option value="0"><?=GetMessage("CAR")?></option>
                            <?foreach ($res_car as $n):
                                $db_props = CIBlockElement::GetProperty(12, $n['ID'],array(),array('ACTIVE' => 'Y'));
                                $PROPS = array();
                                while($ar_props = $db_props->GetNext()){                                
                                    $PROPS[$ar_props['CODE']] = $ar_props['VALUE'];                
                                }
                                if ($PROPS['SHOW_CAR'] == 13){?>
                                <option <?if ($n['ID'] == $arResult['RES_CAR']['ID']): ?>selected="selected"<? endif;?> value="<?=$n["ID"]?>"><?=$n["NAME"]?> <?=$PROPS['YEAR_CAR']?></option>
                            <?}endforeach;?>
                           </select>
                    </label>
                    <label><input autocomplete="off" type="text" class="input must" id="name" name="NAME" placeholder="<?=GetMessage("PLAC_NAME")?>" value=""></label>
                    <label><input autocomplete="off" type="text" class="input" id="email" name="EMAIL" placeholder="<?=GetMessage("PLAC_EMAIL")?>" value=""></label>
                    <label><input autocomplete="off" type="text" class="input must" id="phone" name="PHONE" placeholder="<?=GetMessage("PLAC_PHONE")?>" value=""></label>
                    <label><?$APPLICATION->IncludeComponent(
                                "bitrix:main.calendar", 
                                "calendar_rent", 
                                array(
                                    "SHOW_INPUT" => "Y",
                                    "FORM_NAME" => "",
                                    "INPUT_NAME" => "date_fld",
                                    "INPUT_VALUE" => "",
                                    "INPUT_VALUE_FINISH" => "",
                                    "SHOW_TIME" => "N",
                                    "HIDE_TIMEBAR" => "N",
                                    //"INPUT_ADDITIONAL_ATTR" => "placeholder=\"дд.мм.гггг\"",
                                    "COMPONENT_TEMPLATE" => "calendar_rent",
                                    "INPUT_NAME_FINISH" => ""
                                ),
                                false
                            );
                            ?></label>
                    <label><select id="rent" class="input rent" name="RENT">
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
                    </label>
                    <label><textarea class="textarea" id="smalltext" placeholder="<?=GetMessage("PLAC_COMMENT")?>" name="TEXT"></textarea></label>
                    <label class="invisible"><input autocomplete="off" type="text" id="result" class="input invisible" name="RESULT" placeholder="<?=GetMessage("PLAC_RESULT")?>" value="0"/></label>
                    <div class="invisible">
                        <div id="selday">
                            <?foreach ($dayprice as $key=>$prop):
                                ?><a id="<?=$key?>"><?=$prop['QUANTITY_FROM']?>-<?=$prop['QUANTITY_TO']?>-</a><?   
                            endforeach;?>                                  
                        </div>
                        <div id="selprice">
                            <?foreach ($price as $key=>$prop):
                                ?><a id="<?=$key?>"><?=$prop?>-</a><?   
                            endforeach;?>                                  
                        </div>
                    </div>                            
                    <button type="submit" class="button" id="smalltext order_footrequest "><?=GetMessage("SEND_REQUEST")?></button>
                </form>
                <div class="horizontalgrey horizontalgrey2"></div>               
            </div>