<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
</div>        
        <footer>
        <div <?if (defined('ERROR_404') != true){?>class="invisible"<?}?>>
            <?$APPLICATION->IncludeComponent(
	            "webgk:car.list", 
	            ".default", 
	            array(
		            "CAR" => array(
			            0 => "54",
			            1 => "55",
			            2 => "56",
		            ),
		            "TYPE_SORT" => "ID",
		            "COMPONENT_TEMPLATE" => ".default"
	            ),
	            false
            );?>
        </div>
        <div class="<?if($_SERVER['SCRIPT_URL'] == "/rent/" || $_SERVER['SCRIPT_URL'] == "/404.php" || $_SERVER['REDIRECT_STATUS'] == 200) { ?>invisible<? } ?>">
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
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include", 
                    ".default", 
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/address.php",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>
            </div>
            <div class="bot_contacts">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include", 
                        ".default", 
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/contacts.php",
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    );?>
            </div>
            <div>
                <div class="social_network_1">
					<a href="http://vk.com/rulimcars"><img class="social_network_img" src="/img/vk.png" alt=""></a>
                    <a href="http://facebook.com/rulimcars"><img class="social_network_img" src="/img/fb.png" alt=""></a>
                    <a href="http://twitter.com/rulimcars"><img class="social_network_img" src="/img/tw.png" alt=""></a>
                </div>
                <div class="social_network_2">
                    <a href="http://ok.ru/rulimcars"><img class="social_network_img" src="/img/ok.png" alt=""></a>      
                    <a href="http://avito.ru/rulimcars"><img class="social_network_img" src="/img/av.png" alt=""></a>      
                    <a href="https://www.youtube.com/channel/UCw5s142kq0HqU5vkDghPTtw"><img class="social_network_img" src="/img/yt.png" alt=""></a>      
                </div>
            </div>
        </div>
        </footer>
    </div>    
</body>
<?$APPLICATION->ShowViewContent('myFuncAfterCar');?>
</html>