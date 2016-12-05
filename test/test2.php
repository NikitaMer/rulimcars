<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Test2");
?><? 
$APPLICATION->IncludeComponent("bitrix:main.calendar", "calendar_rent", Array(
	"SHOW_INPUT" => "Y",	// Показывать элемент управления
		"FORM_NAME" => "",	// Имя формы
		"INPUT_NAME" => "date_fld",	// Имя первого поля интервала
		"INPUT_VALUE" => "",	// Значение первого поля интервала
		"INPUT_VALUE_FINISH" => "",	// Значение второго поля интервала
		"SHOW_TIME" => "",	// Позволять вводить время
		"HIDE_TIMEBAR" => "",	// Скрывать поле для ввода времени
		"INPUT_ADDITIONAL_ATTR" => "placeholder=\"дд.мм.гггг\""
	),
	false
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>