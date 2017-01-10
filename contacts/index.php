<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Прокат авто без водителя, аренда автомобилей дешево и удобно в Москве, авто в аренду рядом с метро Водный стадион.");
$APPLICATION->SetPageProperty("keywords", "аренда авто, аренда авто Москва, прокат авто, прокат авто водный стадион, аренда авто водный стадион");
$APPLICATION->SetPageProperty("title", "Контакты RulimCars - аренда автомобилей в Москве");
$APPLICATION->SetTitle("Контакты RulimCars");
?><div class="content">
    <div class="address_all">
         <?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "icons_in_line",
    Array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "COMPONENT_TEMPLATE" => "icons_in_line",
        "DETAIL_URL" => "",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(0=>"",1=>"",),
        "FILTER_NAME" => "",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "11",
        "IBLOCK_TYPE" => "pentagram",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "Y",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "20",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(0=>"",1=>"ICON",2=>"",),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_STATUS_404" => "N",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "TIMESTAMP_X",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC"
    )
);?>
    </div>
    <div class="map">
         <?$APPLICATION->IncludeComponent(
    "bitrix:map.google.view", 
    ".default", 
    array(
        "API_KEY" => "",
        "CONTROLS" => array(
            0 => "SMALL_ZOOM_CONTROL",
            1 => "TYPECONTROL",
            2 => "SCALELINE",
        ),
        "INIT_MAP_TYPE" => "ROADMAP",
        "MAP_DATA" => "a:4:{s:10:\"google_lat\";d:55.839676878241;s:10:\"google_lon\";d:37.483147666626;s:12:\"google_scale\";i:16;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:4:\"TEXT\";s:9:\"RulimCars\";s:3:\"LON\";d:37.48855948448181;s:3:\"LAT\";d:55.839699147438296;}}}",
        "MAP_HEIGHT" => "500",
        "MAP_ID" => "",
        "MAP_WIDTH" => "700",
        "OPTIONS" => array(
            0 => "ENABLE_SCROLL_ZOOM",
            1 => "ENABLE_DBLCLICK_ZOOM",
            2 => "ENABLE_DRAGGING",
            3 => "ENABLE_KEYBOARD",
        ),
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
);?>
    </div>
    <div class="text">
        <div class="partner">
             <a >Наши партнеры:</a> <?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "EDIT_TEMPLATE" => "",
        "PATH" => "/include/partner.php"
    )
);?>
        </div>
        <div class="mail">
            <div class="mail_rent">
                 По вопросам аренды автомобиля<br>
 <a href="mailto:prokat@rulimcars.ru"><?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "EDIT_TEMPLATE" => "",
        "PATH" => "/include/email.php"
    )
);?></a>
            </div>
            <div class="mail_reviews">
                 По вопросам предложений,<br>
                 отзывов о работе и сотрудничества<br>
 <a href="mailto:info@rulimcars.ru"><?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "file",
        "AREA_FILE_SUFFIX" => "inc",
        "EDIT_TEMPLATE" => "",
        "PATH" => "/include/email2.php"
    )
);?></a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="seo">
         <?$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    Array(
        "AREA_FILE_SHOW" => "page",
        "AREA_FILE_SUFFIX" => "inc",
        "EDIT_TEMPLATE" => ""
    )
);?>
    </div>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>