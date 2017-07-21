<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <?include($_SERVER["DOCUMENT_ROOT"]."/include/meta.php");?>    
    <?$APPLICATION->ShowViewContent('myFuncHeadCar');
    $APPLICATION->ShowViewContent('myFuncCar');
    //Actionpay
    if (isset($_GET["actionpay"])){
        setcookie("actionpay", $_GET["actionpay"], time()+60*60*24*30);
    }
    if (isset($_GET["utm_source"])){
        setcookie("utm_source", $_GET["utm_source"], time()+60*60*24*30);
    }
    if (isset($_GET["utm_medium"])){
        setcookie("utm_medium", $_GET["utm_medium"], time()+60*60*24*30);
    }
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WDVQ4V2');</script>
    <!-- End Google Tag Manager -->
    <!-- Actionpay -->
    <script type="text/javascript"> 
    (function (w, d) {
        try {
            var el = 'getElementsByTagName', rs = 'readyState';
            if (d[rs] !== 'interactive' && d[rs] !== 'complete') {
                var c = arguments.callee;
                return setTimeout(function () { c(w, d) }, 100);
            }                                                   
            var s = d.createElement('script');                  
            s.type = 'text/javascript';                         
            s.async = s.defer = true;                           
            s.src = '//aprtx.com/code/rulimcars/';              
            var p = d[el]('body')[0] || d[el]('head')[0];       
            if (p) p.appendChild(s);                            
        } catch (x) { if (w.console) w.console.log(x); }        
    })(window, document);                                       
    </script>
    <!-- End Actionpay -->    
</head>
<body>
<?$APPLICATION->ShowPanel();
$APPLICATION->ShowViewContent("myFuncBodyCar");
?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDVQ4V2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrap">
        <header>
            <div class="header">
                <div class="top_contacts">
                    <div class="phone_alloka <?$APPLICATION->ShowViewContent("black");?>"><?$APPLICATION->IncludeComponent(
	                                                "bitrix:main.include", 
	                                                ".default", 
	                                                array(
		                                                "AREA_FILE_SHOW" => "file",
		                                                "AREA_FILE_SUFFIX" => "inc",
		                                                "EDIT_TEMPLATE" => "",
		                                                "PATH" => "/include/phone_header.php",
		                                                "COMPONENT_TEMPLATE" => ".default"
	                                                ),
	                                                false
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
                    <a<?if ($_SERVER['SCRIPT_URL'] == "/rent/"): ?> <?else:?> href="/"<?endif;?> ><img src="/img/logo<?$APPLICATION->ShowViewContent("black");?>.bmp" alt="" /></a>
                </div>
                <div class="top_address"> 
                        <?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/address2.php",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
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
        <div class="<?if($_SERVER['REDIRECT_STATUS'] == 200) {?>inner_name<?} else {?> title  <?} if($_SERVER['SCRIPT_URL'] == "/rent/") { ?> title_left <? } ?> <?$APPLICATION->ShowViewContent("black");?>">
            <h1><?$APPLICATION->ShowTitle(false);?></h1>
        </div>