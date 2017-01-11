<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);


// Ищем ID товара с нужным автомобилем
$c = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17));
while($c1 = $c->Fetch()){
    $ca = CIBlockElement::GetProperty(17, $c1['ID'])->Fetch();
if ($ca['VALUE'] == $arResult['ID']){
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
//my_dump($arResult);
?>
<div class="background_white">            
                <div class="button_case1">
                    <div id="car_headrentcar" class="button">
                        <a href="/rent/?AUTO=<?=$arResult['ID']?>"><?=GetMessage("RENT")?></a>
                    </div>
                </div>
                <div class="inner_price">
                    <p><?=GetMessage("FROM")?> <a> <?=min($price)?> <span>&#8381;</span></a> <?=GetMessage("BEFORE")?> <a> <?=max($price)?> <span>&#8381;</span></a></p>
                        <?=GetMessage("PER_DAY")?>
                </div>
                <div class="price_car">
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
                    <img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="" />
                    <?endif;?>
                </div>            
        </div>
        <div class="background_grey">
            <div class="content">
                <div class="characteristics_car">
                    <?foreach ($arResult["PROPERTIES"]["ICON"]["VALUE"] as $key => $value):?>
                      <?$icon_id = CIBlockElement::GetByID("$value");
                        $icon_el = $icon_id->GetNextElement(); 
                        $icon_prop = $icon_el->GetFields();?>                                       
                        <div class="characteristics">                     
                            <img src="/img/<?if ($k == 1):?>grey<?else:?>white<?endif;?>/<?=$icon_prop["CODE"]?>.png" alt="" /><br/>
                            <?
                            /*$num=strstr($arResult["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]," ",true);
                            if (ctype_digit(substr($num, -1))) {
                                $arResult["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]=substr($arResult["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key],strlen($num)+1);
                                ?><span><?=$num?></span><?    
                            }*/
                            ?>                    
                            <?=$arResult["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]['TEXT']?>
                        </div>
                    <?endforeach;?>
                </div>
                <?if ($arResult["PROPERTIES"]["SEE_TEXT"]["VALUE"] == "Да"):?>
                    <?if ($arResult["PROPERTIES"]["SELECTION_TEXT"]["VALUE"] == "Два"):?>
                        <table>
                                <tr>                                                        
                                    <td>
                                    <?=$arResult["PROPERTIES"]["TWO_TEXT_ONE"]["~VALUE"]['TEXT']?>  
                                    </td>
                                    <td>
                                    <?=$arResult["PROPERTIES"]["TWO_TEXT_TWO"]["~VALUE"]['TEXT']?>
                                    </td>
                                </tr>
                        </table>
                    <?endif;?>
                    <?if ($arResult["PROPERTIES"]["SELECTION_TEXT"]["VALUE"] == "Один"):?>
                        <?=$arResult["PROPERTIES"]["ONE_TEXT"]["VALUE"]['TEXT']?>
                    <?endif;?>
                <?endif;?>
            </div>
        </div>
        <div class="background_white">
            <div class="content">
                <div class="tariff">
                    ТАРИФЫ
                </div>
                <div class="cells">
                <?foreach ($dayprice as $value):?>
                    <div class="cell">                    
                        <div class="red_circle">
                            <div id="day">
                            <?if ($value['QUANTITY_TO'] == null):?>
                            <span><?=$value['QUANTITY_FROM']?>+</span><br/>
                            <?else:?>
                            <span><?=$value['QUANTITY_FROM']?>-<?=$value['QUANTITY_TO']?></span><br/>
                            <?endif;?>
                            суток
                            </div>
                        </div>
                        <span><?=stristr($value['PRICE'], '.', true)?> <span>&#8381;</span></span><br/>
                        <?=GetMessage("PER_DAY")?>                        
                    </div>
                <?endforeach;?>                                       
                </div>
                <div class="button_case1">
                    <div id="car_footrentcar" class="button">
                        <a href="/rent/?AUTO=<?=$arResult['ID']?>"><?=GetMessage("RENT")?></a>
                    </div>
                </div>
            </div>
        </div>
        <?if ($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] != null){?>
        <div class="background_grey">            
                <div class="inner_car">
                    <table>
                        <tr>
                            <?foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] as $arItem):
                            $car_id = CIBlockElement::GetByID("$arItem");
                            $car_el = $car_id->GetNextElement(); 
                            $car_prop = $car_el->GetFields();?>                                                        
                                <td id="carsbloc" class="table_car">                                                            
                                    <img src="<?=CFile::GetPath($car_prop["PREVIEW_PICTURE"])?>" alt="" />
                                </td>                                
                            <?endforeach;?>
                        </tr>
                        <tr>
                            <?foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] as $arItem):
                            $car_id = CIBlockElement::GetByID("$arItem");
                            $car_el = $car_id->GetNextElement(); 
                            $car_prop = $car_el->GetFields();
                            // Ищем ID товара с нужным автомобилем
                            $c = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17));
                            while($c1 = $c->Fetch()){
                                $ca = CIBlockElement::GetProperty(17, $c1['ID'])->Fetch();
                            if ($ca['VALUE'] == $car_prop['ID']){
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
                            // Приведим цены в лучший вид 
                            $price = array();
                            foreach($dayprice as $key){
                                $price[] = stristr($key['PRICE'], '.', true);        
                            }?>
                                <td>
                                    <a href="<?=$car_prop["DETAIL_PAGE_URL"]?>"><?echo $car_prop["NAME"]?><br/><?=GetMessage("FROM_MINI")?> <?=min($price)?> <span>&#8381;</span></a>
                                </td>                                
                            <?endforeach;?>
                        </tr>
                    </table>
                </div>         
        </div>
        <?}?>
        <div class="content">
            <div class="seo">
                <?if ($arResult['DETAIL_TEXT'] == null){
                    echo ($arResult['PREVIEW_TEXT']);
                }else{
                    echo ($arResult['DETAIL_TEXT']);    
                }?>     
            </div>
        </div>
</div>
<div class="nv_topnav">
<ul>
<?
foreach($arResult['PROPERTIES']['TEXT_LINK']['VALUE'] as $key => $arTextLink):?>
    <li><a href="<?=$arResult['PROPERTIES']['LINK']['VALUE'][$key]?>"><?=$arTextLink?></a></li>
<?endforeach?>
</ul>