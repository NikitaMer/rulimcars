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
// Приведим цены в лучший вид 
$price = array();
foreach($dayprice as $key){
    $price[] = stristr($key['PRICE'], '.', true);        
}
//my_dump($arResult);
?>
<div class="background_white">            
                <div class="button_case">
                    <div class="button">
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
                <div class="button_case">
                    <div class="button">
                        <a href="/rent/?AUTO=<?=$arResult['ID']?>"><?=GetMessage("RENT")?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="background_grey">            
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list", 
                    "mini_list_car", 
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "12",
                        "IBLOCK_TYPE" => "car",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => "4",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array(
                            0 => "NAME_CAR",
                            1 => "PRICE",
                            2 => "",
                        ),
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "Y",
                        "SET_META_KEYWORDS" => "Y",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "COMPONENT_TEMPLATE" => "mini_list_car"
                    ),
                    false
                );?>            
        </div>
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