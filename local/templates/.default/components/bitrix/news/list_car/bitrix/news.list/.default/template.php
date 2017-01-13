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
?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?$i = 1;?>
<?foreach($arResult["ITEMS"] as $arItem):
if ($arItem['PROPERTIES']['SHOW_CAR']['VALUE_ENUM_ID'] == 13){
// Ищем ID товара с нужным автомобилем
$c = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 17));
while($c1 = $c->Fetch()){
    $ca = CIBlockElement::GetProperty(17, $c1['ID'])->Fetch();
if ($ca['VALUE'] == $arItem['ID']){
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
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?> 
    <div class="<?if ($i%2 == 0):?>background_grey<?$k = 0; else:?>background_white<?$k = 1; endif;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
         <div class="content">       
            <div class="price_car">
            <?if ($k == 1):?>                    
                <div id="main_imagecar" class="car">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"/></a>                                      
                </div>
                <div class="price_name">
                    <div id="main_namecar" class="name">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><b><?=$arItem["NAME"]?></b></a> <br/>  
                        <b><?=$arItem["PROPERTIES"]["YEAR_CAR"]["VALUE"]?></b><br/><br/>
                    </div>
                    <div id="main_pricecar" class="price">
                        <?=GetMessage("FROM")?> <a id="price" href="<?=$arItem["DETAIL_PAGE_URL"]?>"> <?=min($price)?> <span>&#8381;</span></a><br/>
                        <?=GetMessage("PER_DAY")?>   <div id="main_morecar" class="more"><a id="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=GetMessage("MORE")?></a></div>                                  
                    </div>
                    <div id="main_rentcar" class="button">
                        <a href="/rent/?AUTO=<?=$arItem['ID']?>"><?=GetMessage("RENT")?></a>
                    </div>
                </div>
            <?else:?>
                <div class="price_name">
                    <div id="main_namecar" class="name">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><b><?=$arItem["NAME"]?></b></a> <br/>  
                        <b><?=$arItem["PROPERTIES"]["YEAR_CAR"]["VALUE"]?></b><br/><br/>
                    </div>
                    <div id="main_pricecar" class="price">
                        <?=GetMessage("FROM")?> <a id="price" href="<?=$arItem["DETAIL_PAGE_URL"]?>"> <?=min($price)?> <span>&#8381;</span></a><br/>
                        <?=GetMessage("PER_DAY")?>   <div id="main_morecar" class="more"><a id="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=GetMessage("MORE")?></a></div>                               
                    </div>
                    <div class="button">
                        <a id="main_rentcar" href="/rent/?AUTO=<?=$arItem['ID']?>"><?=GetMessage("RENT")?></a>
                    </div>
                </div>
                <div id="main_imagecar" class="car">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"  /></a>                                      
                </div>
            <?endif;?>
            </div>                                          
            <div class="characteristics_car">
            <?foreach ($arItem["PROPERTIES"]["ICON"]["VALUE"] as $key => $value):?>
                      <?$icon_id = CIBlockElement::GetByID("$value");
                        $icon_el = $icon_id->GetNextElement(); 
                        $icon_prop = $icon_el->GetFields();?>                                       
                <div class="characteristics">                     
                    <img src="/img/<?if ($k == 1):?>grey<?else:?>white<?endif;?>/<?=$icon_prop["CODE"]?>.png" alt="" /><br/>
                    <?/*
                    $num=strstr($arItem["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]," ",true);
                    if (ctype_digit(substr($num, -1))) {
                        $arItem["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]=substr($arItem["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key],strlen($num)+1);
                        ?><span><?=$num?></span><?    
                    }*/
                    ?>                    
                    <?=$arItem["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]['TEXT']?>
                </div>
            <?endforeach;?>
            </div>                     
         </div>
    </div> 
    <?$i++;?>
<?}endforeach;?>
</div>