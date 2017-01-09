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

?>
<div class="inner_car">
    <table>
        <tr>
            <?foreach($arResult["ITEMS"] as $arItem):?>                                                        
                <td class="table_car">
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>                        
                    <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" />
                    <?endif;?>
                </td>                                
            <?endforeach;?>
        </tr>
        <tr>
            <?foreach($arResult["ITEMS"] as $arItem):
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
            // Приведим цены в лучший вид 
            $price = array();
            foreach($dayprice as $key){
                $price[] = stristr($key['PRICE'], '.', true);        
            }?>
                <td>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?><br/><?=GetMessage("FROM_MINI")?> <?=min($price)?> <span>&#8381;</span></a>
                </td>                                
            <?endforeach;?>
        </tr>
    </table>
</div>