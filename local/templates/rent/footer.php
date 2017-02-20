<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
</div>        
        <footer>       
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
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/include/phone_footer.php",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
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
            <div>
                <div class="social_network_1">
                    <a href="#"><img class="social_network_img" src="/img/vk.png" alt=""></a>
                    <a href="#"><img class="social_network_img" src="/img/fb.png" alt=""></a>
                    <a href="#"><img class="social_network_img" src="/img/tw.png" alt=""></a>
                </div>
                <div class="social_network_2">
                    <a href="#"><img class="social_network_img" src="/img/ok.png" alt=""></a>      
                    <a href="#"><img class="social_network_img" src="/img/av.png" alt=""></a>      
                    <a href="#"><img class="social_network_img" src="/img/yt.png" alt=""></a>      
                </div>
            </div>
        </div>
        </footer>
    </div>    
</body>
<?$APPLICATION->ShowViewContent('myFuncAfterCar');?>
</html>