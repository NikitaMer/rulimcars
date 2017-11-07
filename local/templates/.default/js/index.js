$(document).ready(function () {
    //$("#select_car").change();
    $("input[name='PHONE']").mask("+7(999)999-99-99");
    var EmailCheck=/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,4}$/i;
    var Dat = new Date();
    $('#copyright').find('span').text(Dat.getFullYear());
    
    old_car = null;
    res = new Array();
    // Удаляем значение у input, если в них есть слово "Заполните"        
    $("input.must, select.must").focus(function(){
        var el = $(this), val = el.val();               
        if (val.indexOf("Заполните ") == 0) {
            $(this).val("");
        }        
        $(this).parent().removeClass("nogood");
        $(this).removeClass("nogood");
    });
    /*$("input[name='EMAIL']").focus(function(){
        var el = $(this), val = el.val();               
        if (val.indexOf("Заполните ") == 0) {
            $(this).val("");
        }        
        $(this).parent().removeClass("nogood");
        $(this).removeClass("nogood");
    });*/
    // Отправка данных из формы  
    $(".rentpost").submit(function(){        
        var form = $(this);
        var br = true;
        //проверяем заполненные поля        
        $(this).find("input.must").each(function(){            
            var el = $(this), val = el.val();
            // Не проверяем скрытые поля  
            if ($(this).attr("disabled")) {
                return true;    
            }                 
            if (val.length = 0) {
                $(this).addClass("nogood");
                if (val.length == 0)
                    $(this).val("Заполните " + el.attr("placeholder"));
                br = false;
            }
            if (val.indexOf("Заполните ") == 0) {
                $(this).addClass("nogood");
                if (val.length == 0)
                    $(this).val("Заполните " + el.attr("placeholder"));
                br = false;
            }            
        });
        $(this).find("select.must").each(function(){
            var el = $(this), val = el.val();
            // Не проверяем скрытые поля
            if ($(this).attr("disabled")) {
                return true;    
            }           
            if (val == 0) {
                $(this).addClass("nogood"); 
                br = false;
            }
        });
        $(this).find("input[name='EMAIL']").each(function(){
            var el = $(this), val = el.val();
            if (val.length != 0){
                var validEmail = EmailCheck.test(val);           
                if (!validEmail) {
                    $(this).val("Заполните корректно E-mail");
                    $(this).addClass("nogood"); 
                    br = false;
                } 
            }
        });
        
        if (br) {
            ajaxRent(null, null, true);
        }
                     
        return br;        
    });
    // Мигание селектора для выбора машин
    $('#rentday').find('a').on("click",function(){  
        for(var i=0;i<2;i++){ 
            $('#select_car').fadeOut('slow').fadeIn('fast');
        }                                                                                                                           
    });
    // мигание селектора для выбора дня
    $('#rentres').find('a').on("click",function(){
        for(var i=0;i<2;i++){
            $('#rent').fadeOut('slow').fadeIn('fast');    
        }                                                                                                                                 
    });
    // Запоминаем id старого автомобиля. Нужно для google аналитики
    $("#select_car").click(function(){
        old_car = $('#select_car option:selected').attr('value');     
    });
    // Селектор изменения автомобиля. 
    $("#select_car").change(function(){
        ajaxRent(null, null, false);                                   
        $('#selectimg').find('img').attr("src",$('#select_car option:selected').attr('data_path'));
    });
    // Селектор изменения города.
    $("#select_city").change(function(){
        var carid = $('#select_car option:selected').attr('value');
        var cityid = $('#select_city option:selected').attr('value');   // Запоминаем ID автомобиля
        var res_car_city = '<option value="0" data_path="">Автомобиль</option>';
        var res_airport = '<option value="0">Аэропорт</option>';
        var res_ofice_delivery = '<option value="">Место подачи</option>';
        var res_delivery = '<option value="address">Подать автомобиль по адресу...</option>';
        var res_ofice_return = '<option value="">Место возврата</option>';
        var res_return = '<option value="address">Вернуть автомобиль по адресу...</option>';
        var Resault = ajaxRent(null, null, false);  // Получаем нужные поля по ajax     
        res_car_city +=  Resault['CAR'];
        $("#select_car").html(res_car_city);
        $("#select_car option[value=" + carid + "]").attr('selected', 'true'); // Пробуем выбрать автомобиль, который был выбран до выбора города, после изменения  города.
        $("#select_car_place_delivery").html(Resault['OFFICE']); // Подставляем нужные офисы в селектор для подачи авто
        $("#select_car_place_delivery").append(res_delivery);
        $("#select_car_place_return").html(Resault['OFFICE']);  // Подставляем нужные офисы в селектор для возврата авто
        $("#select_car_place_return").append(res_return);
        $("#select_airport").html(res_airport);
        $("#select_airport").append(Resault['AIRPORT']);   // Подставляем нужные аэропорты в селектор
        if ($('#select_car option:selected').attr('value') == "0") {
            $('#selectimg').find('img').attr("src","");    // Если в выбранном городе нет автомобиля, то удаляем изображение
        }       
    });
    // Отображаем нужный свойства для выбранного типа аренды    
    $("#select_type_rent").change(function(){
        var typeid = $('#select_type_rent option:selected').attr('value');
        if (typeid == 'Трансфер') {
            $(".transfer").css("display","block");
            $(".transfer").find('input').removeAttr('disabled');       
            $(".transfer").find('select').removeAttr('disabled');       
            $(".with_driver").css("display","none");
            $(".with_driver").find('input').attr('disabled','disabled');       
            $(".with_driver").find('select').attr('disabled','disabled');        
            $(".without_driver").css("display","none");
            $(".without_driver").find('input').attr('disabled','disabled');       
            $(".without_driver").find('select').attr('disabled','disabled');                
        } else if (typeid == 'С водителем') {
            $(".transfer").css("display","none");
            $(".transfer").find('input').attr('disabled','disabled');       
            $(".transfer").find('select').attr('disabled','disabled'); 
            $(".with_driver").css("display","block");
            $(".with_driver").find('input').removeAttr('disabled');       
            $(".with_driver").find('select').removeAttr('disabled');
            $(".without_driver").css("display","none");
            $(".without_driver").find('input').attr('disabled','disabled');       
            $(".without_driver").find('select').attr('disabled','disabled');
        } else if (typeid == 'Без водителя') {
            $(".transfer").css("display","none");
            $(".transfer").find('input').attr('disabled','disabled');       
            $(".transfer").find('select').attr('disabled','disabled');
            $(".with_driver").css("display","none");
            $(".with_driver").find('input').attr('disabled','disabled');       
            $(".with_driver").find('select').attr('disabled','disabled');
            $(".without_driver").css("display","block");
            $(".without_driver").find('input').removeAttr('disabled');       
            $(".without_driver").find('select').removeAttr('disabled'); 
        } else {
            $(".transfer").css("display","none");
            $(".transfer").find('input').attr('disabled','disabled');       
            $(".transfer").find('select').attr('disabled','disabled');
            $(".with_driver").css("display","none");
            $(".with_driver").find('input').attr('disabled','disabled');       
            $(".with_driver").find('select').attr('disabled','disabled');
            $(".without_driver").css("display","none");
            $(".without_driver").find('input').attr('disabled','disabled');       
            $(".without_driver").find('select').attr('disabled','disabled');
            $(".type_rent_box").css('display','none');
            $('#select_car').val(0); 
        }
        ajaxRent(null, null, false); 
    });
    // Выбираем направление, если "Тип аренды" = "Трансфер"
    $("#direction_select_airport").change(function(){
        if($('#direction_select_airport option:selected').attr('value') == "IN"){
            $(".address_transfer").attr("placeholder","Адрес отправления");
        } else if ($('#direction_select_airport option:selected').attr('value') == "OUT") {
            $(".address_transfer").attr("placeholder","Адрес назначения");
        }        
    });
    // Выбор даты для подачи и возврата авто
    $("#WITHOUT_DATE_RETURN, #WITH_DATE_RETURN, #WITHOUT_DATE_DELIVERY, #WITH_DATE_DELIVERY, #TRANSFER_DATE_RETURN").change(function(){
        var main_block = $(this).parent().parent();
        var date_delivery;
        var date_return;
        if ($('#select_type_rent option:selected').attr("class") == "option_with_driver") {
            date_delivery = $("#WITH_DATE_DELIVERY").val();        
            date_return = $("#WITH_DATE_RETURN").val();        
        } else if ($('#select_type_rent option:selected').attr("class") == "option_without_driver") {
            date_delivery = $("#WITHOUT_DATE_RETURN").val();        
            date_return = $("#WITHOUT_DATE_DELIVERY").val();
        } else {
            date_delivery = $("#TRANSFER_DATE_RETURN").val();        
            date_return = null;
        }
        ajaxRent(date_delivery, date_return, false);                                                  
    });   
    // Если нужно подать автомобиль по адресу, то открываем input.
    // При выборе Офиса, записываем адрес офиса в скрытый input
    $("#select_car_place_delivery").change(function(){
        var carplaceid = $('#select_car_place_delivery option:selected').attr('value');
        if (carplaceid == 'address') {
            $(".address_delivery_without_driver").val("");
            $(".address_delivery_without_driver").css("display","block");
            $(".address_delivery_without_driver").parent().css("display","block");
        } else {
            $(".address_delivery_without_driver").css("display","none");
            $(".address_delivery_without_driver").parent().css("display","none");
            $(".address_delivery_without_driver").val($('#select_car_place_delivery option:selected').text());
        }
    });
    // Если нужно вернуть автомобиль по адресу, то открываем input.
    // При выборе Офиса, записываем адрес офиса в скрытый input
    $("#select_car_place_return").change(function(){
        var carplaceid = $('#select_car_place_return option:selected').attr('value');
        if (carplaceid == 'address') {
            $(".address_return").val("");
            $(".address_return").css("display","block");
            $(".address_return").parent().css("display","block");
        } else {
            $(".address_return").css("display","none");
            $(".address_return").parent().css("display","none");
            $(".address_return").val($('#select_car_place_return option:selected').text());
        }
    });
    // Выбор аэропорта    
    $("#select_airport").change(function(){
        ajaxRent(null, null, false);                                          
    }); 
    $(".form").find('.button').click(function(){
        $(".rentpost").submit();       
    }); 
    $('#rentday').find('a').text("Выберите город и тип аренды");
    $('#rentday').find('a').css("color" , "#e93f45"); 
    $('#rentres').find('a').text("Выберите город и тип аренды");
    
    function ajaxRent(date_delivery, date_return, button){
        var temp;
        var addres_delivery;
        var addres_return;
        // В зависимости от выбранного типа аренды, берем нужные адреса подачи/возврата
        if ($('#select_type_rent option:selected').attr("class") == "option_with_driver") {
            temp = "with";        
        } else if ($('#select_type_rent option:selected').attr("class") == "option_without_driver") {
            temp = "without";
        }
        if (!date_delivery && $('input.delivery.'+temp).val()) {
            date_delivery = $('input.delivery.'+temp).val();           
        }
        if (!date_return && $('input.return.'+temp).val()) {
            date_return = $('input.return.'+temp).val();           
        }
        if (temp) {    
            addres_delivery = $('input.address_delivery_'+temp+'_driver').val();           
        }
        if (temp) {
            addres_return = $('input.address_return_'+temp+'_driver').val();           
        }
        var city = $('#select_city option:selected').attr('value'); 
        var type_rent = $('#select_type_rent option:selected').attr('value');
        var new_car = $('#select_car option:selected').attr('value');
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var comment = $('#comment').val();                  
        var address_transfer = $('#address_transfer').val();
        var direction_airport = $('#direction_select_airport option:selected').attr('value');      
        var airport = $('#select_airport option:selected').attr('value');
        var result = $('#result').val();
        $.ajax({
          url: "/local/templates/.default/ajax/ajax.php",
          type: "POST",
          data: {
              city: city, 
              type_rent: type_rent,
              new_car: new_car,
              old_car: old_car,
              name: name,
              email: email,
              phone: phone,
              comment: comment,
              date_delivery: date_delivery,
              date_return: date_return,          
              address_transfer: address_transfer,
              direction_airport: direction_airport,
              airport: airport,
              addres_delivery: addres_delivery,
              addres_return: addres_return,
              button: button,
              result: result,
          }, 
          success: function(data){
              res = $.secureEvalJSON( data );                       
          }, 
          async: false               
        });
        // Подставляем ответ в нужные поля
        if (res['RENTDAY']) {
            $('#rentday').html(res['RENTDAY']);        
        }
        if (res['RENTDAY_IN_A']){
            $('#rentday').find('a').text(res['RENTDAY_IN_A']);    
        } else {
            $('#rentday').find('a').text(res['PRICE_IN_DAY']);
            $("#result").val(res["PRICE_RES"]);
            $("#days").val(res["DAYS"]); 
        }
        if (res['RENTDAY_RED']) {
            $('#rentday').find('a').css("color" , "#e93f45");    
        } else {
            $('#rentday').find('a').css("color" , "#5d5d5d");    
        }
        if (res['RENTRES_IN_A']) {
            $('#rentres').find('a').text(res['RENTRES_IN_A']);
        } else {
            $('#rentres').find('a').text(res['PRICE_RES']);
            $("#result").val(res["PRICE_RES"]); 
            $("#days").val(res["DAYS"]);
        }
        if (res["ORDER_ID"]) {
            $("#orderid").val(res["ORDER_ID"]);    
        }
        // Если возник серьезная пижня то выводим эту хрень
        if (res["ERROR"]) {
            alert("Возникла проблема с выбором автомобиля. Выбирете другой автомобиль");    
        }
        // Тут нужно доделать. Проблема в том, что раньше был один тип цен сечас их 3. И какой вписывать в поле не изместно.
        //ChangeCar(NewCarID, NewCarName, NewCarYear, NewCarPrice, OldCarID, OldCarName, OldCarYear, OldCarPrice)
        
        return  res;   
    }     
});
// Делаем недоступными к выбору даты меньше текущей в стандартном календаре битрикса
function changeCalendar() {
    var el = $('.bx-calendar'); //найдем div  с календарем
    var links = el.find(".bx-calendar-cell"); //найдем элементы отображающие дни
    $('.bx-calendar-left-arrow').attr({'onclick': 'changeCalendar();',}); //вешаем функцию изменения  календаря на кнопку смещения календаря на месяц назад
    $('.bx-calendar-right-arrow').attr({'onclick': 'changeCalendar();',}); //вешаем функцию изменения  календаря на кнопку смещения календаря на месяц вперед
    $('.bx-calendar-top-month').attr({'onclick': 'changeMonth();',}); //вешаем функцию изменения  календаря на кнопку выбора месяца
    var date = new Date();
    for (var i =0; i <= links.length-1; i++)
    {
        var atrDate = links[i].attributes['data-date'].value;
        var d = date.valueOf();
        var g = links[i].innerHTML;
        if (date - atrDate > 24*60*60*1000) {
            $('[data-date="' + atrDate +'"]').addClass("bx-calendar-date-hidden disabled"); //меняем класс у элемента отображающего день, который меньше по дате чем текущий день
            $('[data-date="' + atrDate +'"]').removeAttr("href");
            $('[data-date="' + atrDate +'"]').removeAttr("data-date");
        }
    }
}
function changeMonth() {
    var el = $('[id ^= "calendar_popup_month_"]'); //найдем div  с календарем
    var links = el.find(".bx-calendar-month");
    for (var i =0; i <= links.length; i++) {
        var func = links[i].attributes['onclick'].value;
        $('[onclick="' + func +'"]').attr({'onclick': func + '; changeCalendar();',}); //повесим событие на выбор месяца
    }
}
/**
* Код для Google Tag Manager при смене селектора автомобиля на стр. "Заявка на аренду"
* @param NewCarID - ID нового автомобиля 
* @param NewCarName - Назавание нового автомобиля
* @param NewCarYear - Год нового автомобиля
* @param NewCarPrice - Максимальная цена нового автомобиля
* @param OldCarID - ID старого автомобиля
* @param OldCarName - Назавание старого автомобиля
* @param OldCarYear - Год старого автомобиля
* @param OldCarPrice - Максимальная цена старого автомобиля
*/
function ChangeCar(NewCarID, NewCarName, NewCarYear, NewCarPrice, OldCarID, OldCarName, OldCarYear, OldCarPrice) {
    dataLayer.push({
          'event': 'addToCart',
          'ecommerce': {
            'currencyCode': 'RUR',
            'add': {                                
              'products': [{                        
                'name': NewCarName+' '+NewCarYear,    
                'id': NewCarID,         
                'price': NewCarPrice,          
                'quantity': 1                
               }]
            }
          },
        'event': 'removeFromCart',
          'ecommerce': {
            'remove': {                               
              'products': [{                          
                  'name': OldCarName+' '+OldCarYear,    
                  'id': OldCarID,        
                  'price': OldCarPrice,        
                  'quantity': 1            
              }]
            }
          }
        });
};
/**
* Код для Google Tag Manager, когда заходим на стр. "Заявка на аренду" 
* @param CarName - Название автомобиля
* @param CarYear - Год автомобиля
* @param CarID - ID автомобиля
* @param CarPrice - Максимальная цена автомобиля
*/
function PresentCar(CarName, CarYear, CarID, CarPrice){ 
    dataLayer.push({
      'event': 'addToCart',
      'ecommerce': {
        'currencyCode': 'RUR',
        'add': {
          'products': [{
            'name': CarName+' '+CarYear,
            'id': CarID,
            'price': CarPrice,
            'quantity': 1
           }]
        }
      }
    });    
};