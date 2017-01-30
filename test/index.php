<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST");?>

<? $APPLICATION->IncludeComponent(
"car:car.list",
".default",
Array(
),
false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>