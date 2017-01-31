<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("К сожалению, такой страницы не существует, перейдите на главную страницу");
?>
<div style="text-align: center;" class="content">
    <img  src="/img/red_brick.png" alt="">
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>