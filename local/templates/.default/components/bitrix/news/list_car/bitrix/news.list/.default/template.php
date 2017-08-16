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
// Приводим цены в лучший вид 
$price = array();
foreach($arItem['DAY_PRICE'] as $key){
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
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'imagecar');"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"/></a>                                      
                </div>
                <div class="price_name">
                    <div id="main_namecar" class="name">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'namecar');"><b><?=$arItem["NAME"]?></b></a> <br/>  
                        <b><?=$arItem["PROPERTIES"]["YEAR_CAR"]["VALUE"]?></b><br/><br/>
                    </div>
                    <div id="main_pricecar" class="price">
                        <?=GetMessage("FROM")?> <a id="price" href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'pricecar');"> <?=min($price)?> <span>&#8381;</span></a><br/>
                        <?=GetMessage("PER_DAY")?>   <div id="main_morecar" class="more"><a id="more" href="<?=$arItem["DETAIL_PAGE_URL"]?>" onclick="ga('send', 'event', 'carbutton', 'go2car', 'morecar');"><?=GetMessage("MORE")?></a></div>                                  
                    </div>
                    <div id="main_rentcar">
                        <form method="post" action="/rent/">
                            <input type="hidden" name="AUTO" value="<?=$arItem['ID']?>">
                            <button type="submit" class="button" onclick="ga('send', 'event', 'rentbutton', 'go2rent', 'mainpage');"><?=GetMessage("RENT")?></button>
                        </form>
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
                    <div id="main_rentcar">
                        <form method="post" action="/rent/">
                            <input type="hidden" name="AUTO" value="<?=$arItem['ID']?>">
                            <button type="submit" class="button"><?=GetMessage("RENT")?></button>
                        </form>
                    </div>
                </div>
                <div id="main_imagecar" class="car">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"  /></a>                                      
                </div>
            <?endif;?>
            </div>                                          
            <div class="characteristics_car">
            <?foreach ($arItem["PROPERTIES"]["ICON"]["VALUE"] as $key => $value):?>
                      <?$icon = GetIBlockElement("$value");?>                                       
                <div class="characteristics">                     
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="/img/<?if ($k == 1):?>grey<?else:?>white<?endif;?>/<?=$icon["CODE"]?>.png" alt="" /></a><br/>                
                    <?=$arItem["PROPERTIES"]["TEXT_ICON"]["VALUE"][$key]['TEXT']?>
                </div>
            <?endforeach;?>
            </div>                     
         </div>
    </div> 
    <?$i++;?>
<?}endforeach;?>
</div>