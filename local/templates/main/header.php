<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <?include($_SERVER["DOCUMENT_ROOT"]."/include/meta.php");?> 
</head>
<body>
<?$APPLICATION->ShowPanel();?>
    <div class="wrap">
        <header>
            <div class="header">
                <div class="top_contacts">
                    <div class="phone"><?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/phone.php"
                            )
                        );?></div>
                    <div class="email"><?$APPLICATION->IncludeComponent(
	                                        "bitrix:main.include", 
	                                        ".default", 
	                                        array(
		                                        "AREA_FILE_SHOW" => "file",
		                                        "AREA_FILE_SUFFIX" => "inc",
		                                        "EDIT_TEMPLATE" => "",
		                                        "PATH" => "/include/email.php",
		                                        "COMPONENT_TEMPLATE" => ".default"
	                                        ),
	                                        false
                                        );?></div>
                </div>
                <div class="logo">
                    <a<?if ($_SERVER['SCRIPT_URL'] == "/rent/"): ?> <?else:?> href="/"<?endif;?> ><img src="/img/logo.bmp" alt="" /></a>
                </div>
                <div class="top_address"> 
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/address.php"
                            )
                        );?>
                </div>
            </div>
        </header>
        <div <?if($_SERVER['SCRIPT_URL'] == "/rent/") { ?>class=" invisible "<? } ?>>
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu",
            "top_menu",
            Array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "COMPONENT_TEMPLATE" => "horizontal_multilevel",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => "",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_THEME" => "yellow",
                "ROOT_MENU_TYPE" => "top",
                "USE_EXT" => "N"
            )
        );?>
        </div>
        <div class="container">
        <div class="<?if($_SERVER['REDIRECT_STATUS'] == 200) {?>inner_name<?} else {?> title  <?} if($_SERVER['SCRIPT_URL'] == "/rent/") { ?> title_left <? } ?>">
            <b><?//$APPLICATION->ShowProperty("H1");?></b>
            <b><?$APPLICATION->ShowTitle(false)?></b>
        </div>