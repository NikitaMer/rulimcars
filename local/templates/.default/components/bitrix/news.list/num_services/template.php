<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>

<div class="services1">
    <div class="red_line">
    </div>
    <div class="cells">
    <?for ($i=0; $i<=2;$i++):?>
    <?
    $this->AddEditAction($arResult['ITEMS'][$i]['ID'], $arResult['ITEMS'][$i]['EDIT_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][$i]["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arResult['ITEMS'][$i]['ID'], $arResult['ITEMS'][$i]['DELETE_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][$i]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
        <div class="cell number" id="<?=$this->GetEditAreaId($arResult['ITEMS'][$i]['ID']);?>">
            <div class="red_circle"> 
                <div>
                     <span><?=$arResult['ITEMS'][$i]['NAME']?></span>
                </div>
            </div>
            <p>
                 <?=$arResult['ITEMS'][$i]['DETAIL_TEXT']?>
            </p>
        </div>
    <?endfor;?>
    </div>
</div>
<div class="services2">
    <div class="red_line">
    </div>
    <div class="cells">
<?for ($i=3; $i<=4;$i++):?>
    <?
    $this->AddEditAction($arResult['ITEMS'][$i]['ID'], $arResult['ITEMS'][$i]['EDIT_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][$i]["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arResult['ITEMS'][$i]['ID'], $arResult['ITEMS'][$i]['DELETE_LINK'], CIBlock::GetArrayByID($arResult['ITEMS'][$i]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
        <div class="cell number" id="<?=$this->GetEditAreaId($arResult['ITEMS'][$i]['ID']);?>">
            <div class="red_circle"> 
                <div>
                     <span><?=$arResult['ITEMS'][$i]['NAME']?></span>
                </div>
            </div>
            <p>
                 <?=$arResult['ITEMS'][$i]['DETAIL_TEXT']?>
            </p>
        </div>
    <?endfor;?>
    </div>
</div>
