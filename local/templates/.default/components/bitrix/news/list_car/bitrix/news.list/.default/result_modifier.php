<?
foreach($arResult["ITEMS"] as $key=>$arItem):
if ($arItem['PROPERTIES']['SHOW_CAR']['VALUE_ENUM_ID'] == 13){
// Получаем цены
$CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arItem['PROPERTIES']['CATALOG']['VALUE'],));
while($CPrice1 = $CPrice->Fetch()){
    $arResult["ITEMS"][$key]['DAY_PRICE'][] = $CPrice1;
}
}endforeach;