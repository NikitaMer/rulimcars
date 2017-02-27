<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?> 
</div>        
        <footer>       
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
        </footer>
    </div>    
</body>
<?$APPLICATION->ShowViewContent('myFuncAfterCar');?>
</html>