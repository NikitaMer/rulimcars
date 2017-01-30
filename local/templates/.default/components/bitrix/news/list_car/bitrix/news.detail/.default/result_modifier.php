<?
// Получаем цены из инфоблока "Каталог"
$CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arResult['PROPERTIES']['CATALOG']['VALUE'],));
while($CPrice1 = $CPrice->Fetch()){
    $arResult['DAY_PRICE'][] = $CPrice1;
}
//
foreach($arResult["PROPERTIES"]["SIMILAR_CAR"]["VALUE"] as $key=>$arItem):
$car_prop = GetIBlockElement($arItem);
$car_catolog = CIBlockElement::GetProperty(12, $arItem, array("sort"=>"asc"), array("CODE"=>"CATALOG"))->Fetch();
$CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $car_catolog['VALUE'],));
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["ID"] = $arItem;
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["PREVIEW_PICTURE"] = CFile::GetPath($car_prop["PREVIEW_PICTURE"]);
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["DETAIL_PAGE_URL"] = $car_prop["DETAIL_PAGE_URL"];
    $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["NAME"] = $car_prop["NAME"];
    while($CPrice1 = $CPrice->Fetch()){        
        $arResult["PROPERTIES"]["SIMILAR_CAR"]["CAR_VALUE"][$key]["PRICE"] = stristr($CPrice1["PRICE"], '.', true);
    }
endforeach;