<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST");?><?$APPLICATION->IncludeComponent(
	"car:car.list", 
	".default", 
	array(
		"CAR" => array(
		),
		"TYPE_SORT" => "ID",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>