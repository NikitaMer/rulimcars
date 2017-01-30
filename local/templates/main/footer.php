<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
</div>        
        <footer>
        <div class="<?if($_SERVER['SCRIPT_URL'] == "/rent/" || $_SERVER['REDIRECT_STATUS'] == 200) { ?> invisible <? } ?>">
        <?$APPLICATION->IncludeComponent(
            "bitrix:menu", 
            "bot_menu", 
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "COMPONENT_TEMPLATE" => "bot_menu",
                "DELAY" => "N",
                "MAX_LEVEL" => "1",
                "MENU_CACHE_GET_VARS" => array(),
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_THEME" => "yellow",
                "ROOT_MENU_TYPE" => "bottom",
                "USE_EXT" => "N"
            ),
            false
        );?>
        </div>        
        <div class="footer">
            <div class="bot_addres">
            Наш офис расположен по адресу:
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
            <br/>
            <br/>

            <div class="copyright">Copyright 2014-<span>2017</span>, all rights reserved</div>
            
            </div>
            <div class="bot_contacts">
                <div class="phone">Тел: <?$APPLICATION->IncludeComponent(
                                            "bitrix:main.include",
                                            "",
                                            Array(
                                                "AREA_FILE_SHOW" => "file",
                                                "AREA_FILE_SUFFIX" => "inc",
                                                "EDIT_TEMPLATE" => "",
                                                "PATH" => "/include/phone.php"
                                            )
                                        );?>
                </div>
                <br/>
                <div class="email">
                <?$APPLICATION->IncludeComponent(
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
                );?><br/>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/email2.php"
                    )
                );?>
                </div>
            </div>
            <div class="feedback">
                <!--<a href="#" class="a">Обратная связь</a>-->
            </div>
        </div>
        </footer>
    </div>    
</body>
<?$APPLICATION->ShowViewContent('myFuncAfterCar');?>
</html>