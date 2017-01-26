<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$arTemplateParameters = array(
    "HOURS" => array(
            "PARENT" => "PARAMS",
            "NAME" => GetMessage("TIME"),
            "TYPE" => "INT",
            "MULTIPLE" => "N",
            "DEFAULT" => 16
    )
);