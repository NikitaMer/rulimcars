<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<?
if ($arParams['SILENT'] == 'Y') return;

$cnt = strlen($arParams['INPUT_NAME_FINISH']) > 0 ? 2 : 1;

for ($i = 0; $i < $cnt; $i++):
    if ($arParams['SHOW_INPUT'] == 'Y'):
?>
<input disabled="disabled" autocomplete="off" name="<?=$arParams["INPUT_NAME"]?>" placeholder="<?if($arParams["INPUT_CLASS"] == "without"){ echo GetMessage("DATE_RETURN");}else{echo GetMessage("DATE_TIME_RETURN");}?>" type="text" id="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>" class="input date return <?=$arParams["INPUT_CLASS"]?>" <?=(Array_Key_Exists("~INPUT_ADDITIONAL_ATTR", $arParams)) ? $arParams["~INPUT_ADDITIONAL_ATTR"] : ""?> onclick="BX.calendar({node:this, field:'<?=htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]))?>', form: '<?if ($arParams['FORM_NAME'] != ''){echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', bTime: <?=$arParams['SHOW_TIME'] == 'Y' ? 'true' : 'false'?>, currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: <?=$arParams['HIDE_TIMEBAR'] == 'Y' ? 'true' : 'false'?>}); changeCalendar();"/>
<?
    endif;
?><?
endfor;
?>