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
    $APPLICATION->ShowViewContent('myFuncCar');?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WDVQ4V2');</script>
    <!-- End Google Tag Manager --> 
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-58012450-1', 'auto');
      ga('send', 'pageview');
    </script>  
</head>
<body>
<?$APPLICATION->ShowPanel();
$APPLICATION->ShowViewContent("myFuncBodyCar");?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDVQ4V2"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="wrap">
        <header>
            <div class="header">
                <div class="top_contacts">
                    <div class="phone_alloka"><?$APPLICATION->IncludeComponent(
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
                    <img src="/img/logo.bmp" alt="" />
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
        <div class="container">
        <div class="title_left">
            <h1><?$APPLICATION->ShowTitle(false);?></h1>
        </div> 