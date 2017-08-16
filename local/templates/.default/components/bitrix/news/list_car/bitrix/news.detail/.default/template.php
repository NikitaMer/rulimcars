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
// Приводим цены в лучший вид
$price = array();
foreach($arResult['DAY_PRICE'] as $key){
    $price[] = stristr($key['PRICE'], '.', true);        
} 
// Добавляем текст, который должен быть JS кодом, в HEAD
$this->SetViewTarget("myFuncHeadCar");
    echo $arResult['PROPERTIES']['SCRIPT_IN_HEAD']['~VALUE']['TEXT'];
$this->EndViewTarget();
// Добавляем текст, который должен быть JS кодом, в BODY
$this->SetViewTarget("myFuncBodyCar");
    echo $arResult['PROPERTIES']['SCRIPT_IN_BODY']['~VALUE']['TEXT'];
$this->EndViewTarget();
// Добавляем текст, который должен быть JS кодом, после BODY
$this->SetViewTarget("myFuncAfterCar");
    echo $arResult['PROPERTIES']['SCRIPT_AFTER_BODY']['~VALUE']['TEXT'];
$this->EndViewTarget();
?>
<script> window.APRT_DATA = {pageType: 0};</script>
<?
// Добавляем код в HEAD 
$this->SetViewTarget("myFuncCar");?>
    <script>
    function (productObj) {
      dataLayer.push({
        'event': 'productClick',
        'ecommerce': {
          'click': {
            'actionField': {'list': '<?if (substr_count($_SERVER['HTTP_REFERER'], rulimcars) != 0){ echo $_SERVER['HTTP_REFERER'];}?>'},      
            'products': [{
              'name': '<?=$arResult['NAME']." ".$arResult['PROPERTIES']['YEAR_CAR']['VALUE']?>',      
              'id': '<?=$arResult['CODE']?>',         
              'price': '<?=$arResult['DAY_PRICE'][0]['PRICE']?>'         
             }]
           }
         },
         'eventCallback': function() {
           document.location = productObj.url
         }
      });
    }
    ga('require', 'ec');
    ga('ec:addImpression', {
      'name': 'Лада Ларгус Фургон', 
    });
    </script>
<?$this->EndViewTarget();

// Изменение цветов на сайте                          
if($arResult["PROPERTIES"]["BLACK"]["VALUE"] == "Black"){      
    $black = "_black";
    $background_black = "background_black";
    $this->SetViewTarget("black");
        echo $black;
    $this->EndViewTarget();                
}
?>
<div class="background_white">            
    <div class="button_case1">
        <div id="car_headrentcar">
            <form method="post" action="/rent/">
                <input type="hidden" name="AUTO" value="<?=$arResult['ID']?>">
                <button type="submit" class="button <?=$background_black?>" onclick="ga('send', 'event', 'rentbutton', 'go2rent', 'carheadrentcar');"><?=GetMessage("RENT")?></button>
            </form>
        </div>
    </div>
    <div class="inner_price <?=$black?>">
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
              <?$icon = GetIBlockElement("$value");?>                                       
                <div class="characteristics">                     
                    <img src="/img/<?if ($k == 1):?>grey<?else:?>white<?endif;?>/<?=$icon["CODE"]?>.png" alt="" /><br/>                    
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
        <div class="tariff <?=$black?>">
            ТАРИФЫ
        </div>
        <div class="cells <?=$black?>">
        <?foreach ($arResult['DAY_PRICE'] as $value):?>
            <div class="cell">                    
                <div class="red_circle <?=$background_black?>">
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
                    <button type="submit" class="button <?=$background_black?>" onclick="ga('send', 'event', 'rentbutton', 'go2rent', 'carheadrentcar');"><?=GetMessage("RENT")?></button>
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
                    <?// Выводим автомобили
                    foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"] as $arItem):?>                                                        
                        <td id="carsbloc" class="table_car">                                                            
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'footercar');"><img src="<?=$arItem["PREVIEW_PICTURE"]?>" alt="" /></a>
                        </td>                                
                    <?endforeach;?>
                </tr>
                <tr>
                    <?foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"] as $arItem):?>
                        <td>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'footercar');"><?echo $arItem["NAME"]?><br/><?=GetMessage("FROM_MINI")?> <?=$arItem["PRICE"]?> <span>&#8381;</span></a>
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
    <li><a href="<?=$arResult['PROPERTIES']['TEXT_LINK']['VALUE'][$key]?>"><?=$arTextLink?></a></li>
<?endforeach?>
</ul>