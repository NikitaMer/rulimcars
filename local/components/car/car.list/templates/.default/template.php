<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if ($arResult != null){?>
<div class="background_grey">
<div class="inner_car">
    <table>
        <tr>
            <?foreach($arResult["CAR"] as $arItem):?>                                                        
                <td id="carsbloc" class="table_car">                                           
                    <img src="<?=CFile::GetPath($arItem["PREVIEW_PICTURE"])?>" alt="" />
                </td>                                
            <?endforeach;?>
        </tr>
        <tr>
            <?foreach($arResult["CAR"] as $arItem):
                $CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arItem["PROPERTIES"]["CATALOG"]['VALUE'],));                
                while($CPrice1 = $CPrice->Fetch()){                            
                    $price = stristr($CPrice1["PRICE"], '.', true);
                }
            ?>
                <td>
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?><br/>от <?=$price?> <span>&#8381;</span></a>
                </td>                                
            <?endforeach;?>
        </tr>
    </table>
</div>
</div>
<?}?>