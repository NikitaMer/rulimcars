<?
// Получаем цены из инфоблока "Каталог"
$CPrice = CPrice::GetList(array(), array("IBLOCK_ID" => 17,"PRODUCT_ID" => $arResult['PROPERTIES']['CATALOG']['VALUE'],));
while($CPrice1 = $CPrice->Fetch()){
    $arResult['DAY_PRICE'][] = $CPrice1;
}