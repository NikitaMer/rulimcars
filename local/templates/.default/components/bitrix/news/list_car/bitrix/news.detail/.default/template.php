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

$CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arResult['PROPERTIES']['CATALOG']['VALUE'],));
$dayprice =array();
while($CPrice1 = $CPrice->Fetch()){
    $dayprice[] = $CPrice1;
}
// Приводим цены в лучший вид 
$price = array();
foreach($dayprice as $key){
    $price[] = stristr($key['PRICE'], '.', true);        
}
$this->SetViewTarget("myFuncHeadCar");
    echo $arResult['PROPERTIES']['SCRIPT_IN_HEAD']['~VALUE']['TEXT'];
$this->EndViewTarget();
$this->SetViewTarget("myFuncBodyCar");
    echo $arResult['PROPERTIES']['SCRIPT_IN_BODY']['~VALUE']['TEXT'];
$this->EndViewTarget();
$this->SetViewTarget("myFuncAfterCar");
    echo $arResult['PROPERTIES']['SCRIPT_AFTER_BODY']['~VALUE']['TEXT'];
$this->EndViewTarget();
$name = $arResult['NAME'];
$years = $arResult['PROPERTIES']['YEAR_CAR']['VALUE'];
$code = $arResult['CODE'];
$maxpric = $dayprice[0]['PRICE']; 
$this->SetViewTarget("myFuncCar");?>
        <script>
            function (productObj) {
              dataLayer.push({
                'event': 'productClick',
                'ecommerce': {
                  'click': {
                    'actionField': {'list': '<?if (substr_count($_SERVER['HTTP_REFERER'], rulimcars) != 0){ echo $_SERVER['HTTP_REFERER'];}?>'},      
                    'products': [{
                      'name': '<?=$name." ".$years?>',      
                      'id': '<?=$code?>',         
                      'price': '<?=$maxpric?>'         
                     }]
                   }
                 },
                 'eventCallback': function() {
                   document.location = productObj.url
                 }
              });
            }
            </script>
<?$this->EndViewTarget();
?>
<div class="background_white">            
                <div class="button_case1">
                    <div id="car_headrentcar">
                        <form method="post" action="/rent/">
                            <input type="hidden" name="AUTO" value="<?=$arResult['ID']?>">
                            <button type="submit" class="button"><?=GetMessage("RENT")?></button>
                        </form>
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
                    <div id="car_footrentcar">
                        <form method="post" action="/rent/">
                            <input type="hidden" name="AUTO" value="<?=$arResult['ID']?>">
                            <button type="submit" class="button"><?=GetMessage("RENT")?></button>
                        </form>
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
                            $car_prop = GetIBlockElement($arItem);?>                                                        
                                <td id="carsbloc" class="table_car">                                                            
                                    <img src="<?=CFile::GetPath($car_prop["PREVIEW_PICTURE"])?>" alt="" />
                                </td>                                
                            <?endforeach;?>
                        </tr>
                        <tr>
                            <?foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] as $arItem):
                            $car_prop = GetIBlockElement($arItem);
                            $carcatolog = CIBlockElement::GetProperty(12, $arItem, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->Fetch(); 
                            $CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $carcatolog['VALUE'],));
                            $dayprice =array();
                            while($CPrice1 = $CPrice->Fetch()){
                                $dayprice[] = $CPrice1;
                            }
                            // Приводим цены в лучший вид 
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
foreach($arResult['PROPERTIES']['TEXT_LINK']['DESCRIPTION'] as $key => $arTextLink):?>
    <li><a href="<?=$arResult['PROPERTIES']['LINK']['VALUE'][$key]?>"><?=$arTextLink?></a></li>
<?endforeach?>
</ul>