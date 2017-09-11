$(document).ready(function () {
    $("input[name='PHONE']").mask("+7(999)999-99-99");
    var EmailCheck=/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,4}$/i;
    var Dat = new Date();
    res = new Array();
    $('#copyright').find('span').text(Dat.getFullYear());       
    $("input.must, select.must").focus(function(){
        var el = $(this), val = el.val();               
        if (val.indexOf("Заполните ") == 0) {
            $(this).val("");
        }        
        $(this).parent().removeClass("nogood");
        $(this).removeClass("nogood");
    });
    $("input[name='EMAIL']").focus(function(){
        var el = $(this), val = el.val();               
        if (val.indexOf("Заполните ") == 0) {
            $(this).val("");
        }        
        $(this).parent().removeClass("nogood");
        $(this).removeClass("nogood");
    });  
    $(".rentpost").submit(function(){        
        var form = $(this);
        //проверяем заполненные поля
        var br=0;
        $(this).find("input.must").each(function(){            
            var el = $(this), val = el.val(); 
            if ($(this).attr("disabled")) {
                return true;    
            }                 
            if (val.length > 0) {}
            else {
                $(this).addClass("nogood");
                if (val.length == 0)
                    $(this).val("Заполните " + el.attr("placeholder"));
                br = "yes";
            }
            if (val.indexOf("Заполните ") == 0) {
                $(this).addClass("nogood");
                if (val.length == 0)
                    $(this).val("Заполните " + el.attr("placeholder"));
                br = "yes";
            }            
        });
        $(this).find("select.must").each(function(){
            var el = $(this), val = el.val();
            if ($(this).attr("disabled")) {
                return true;    
            }           
            if (val != 0) {}
            else {
                $(this).addClass("nogood"); 
                br = "yes";
            }
        });
        $(this).find("input[name='EMAIL']").each(function(){
            var el = $(this), val = el.val();
            if (val.length != 0){
                var validEmail = EmailCheck.test(val);           
                if (validEmail) {}
                else {
                    $(this).val("Заполните корректно E-mail");
                    $(this).addClass("nogood"); 
                    br = "yes";
                } 
            }
        });              
        if (br == "yes") {            
            return false;
        }                                                                                           
        else {             
            return true;
        }        
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
    $("#select_car").click(function(){
        oldcarid = $('#select_car option:selected').attr('value');     
    });
    $("#select_car").change(function(){
        var newcarid = $('#select_car option:selected').attr('value');
        var src = $('#select_car option:selected').attr('data_path');       
        $('#selectimg').find('img').attr("src",$('#select_car option:selected').attr('data_path'));

        if(newcarid != 0){      
            $.ajax({
              url: "/local/templates/.default/ajax/change_car.php",
              type: "POST",
              data: {newcar: newcarid, oldcar: oldcarid},
              success: function(data){
                    res = $.secureEvalJSON( data );                       
                },
              async: false               
            });      
            new_car = new Array(); 
            new_car_price_day = new Array(); 
            new_car_price_hour = new Array(); 
            new_car_day = new Array();    
            $.each(res['NEW_CAR']['PRICES'],function(index,value) {            
                new_car[value['TYPE_RENT']] = value['OFFER'];                                                     
            });
            if(new_car['DAY']){
                $.each(new_car['DAY'],function(index,value) {            
                    new_car_price_day.push(Number(value['PRICE']));                                                      
                    new_car_day.push(Number(value['QUANTITY_FROM']));                                                      
                    new_car_day.push(Number(value['QUANTITY_TO']));                                                      
                });
            }
            if(new_car['HOUR']){
                $.each(new_car['HOUR'],function(index,value) {            
                    new_car_price_hour.push(Number(value['PRICE']));                                                      
                });    
            }                                          
            if(res['OLD_CAR']){
                old_car = new Array(); 
                $.each(res['OLD_CAR']['PRICES'],function(index,value) {            
                    old_car[value['TYPE_RENT']] = value['OFFER'];                                                      
                });
                ChangeCar(newcarid, res['NEW_CAR']['NAME'], res['NEW_CAR']['YEAR'], new_car['DAY'][0]['PRICE'], oldcarid, res['OLD_CAR']['NAME'], res['OLD_CAR']['YEAR'], old_car['За сутки'][0]['PRICE']);           
            }else{
                ChangeCar(newcarid, res['NEW_CAR']['NAME'], res['NEW_CAR']['YEAR'], new_car['DAY'][0]['PRICE'], 0, null, null, 0);           
            }
              
            console.log(new_car_day);
            console.log(new_car_price_day);
        }
        
        if ($("#select_type_rent").val() == 0) {
            $("#WITHOUT_DATE_RETURN, #WITH_DATE_RETURN, #WITHOUT_DATE_DELIVERY, #WITH_DATE_DELIVERY, #TRANSFER_DATE_RETURN").change();
        } else if ($("#select_type_rent").val() == "TRANSFER") {
            $("#TRANSFER_DATE_RETURN").change();  
        } else if ($("#select_type_rent").val() == "WITH_DRIVER") {
            $("#WITH_DATE_RETURN,  #WITH_DATE_DELIVERY").change(); 
        } else if ($("#select_type_rent").val() == "WITHOUT_DRIVER") {
            $("#WITHOUT_DATE_RETURN, #WITHOUT_DATE_DELIVERY").change();  
        }
        
    });
    $("#WITHOUT_DATE_RETURN, #WITH_DATE_RETURN, #WITHOUT_DATE_DELIVERY, #WITH_DATE_DELIVERY, #TRANSFER_DATE_RETURN").change(function(){
        var main_block = $(this).parent().parent();
         
        if($("#select_car").val() == "0"){
           $('#rentday').find('a').text("Выберите автомобиль");
           $('#rentday').find('a').css("color" , "#e93f45");
           if ($("#select_type_rent").val() == "TRANSFER") {
                $('#rentres').find('a').text("Выберите дату подачи");    
           } else if ($("#select_type_rent").val() == 0) {
                $('#rentres').find('a').text("Выберите тип аренды");
           } else {
                $('#rentres').find('a').text("Выберите дату подачи/возврата");   
           } 
           $('#result').val('');   
        }else if (main_block.find('input.delivery').val() == "" || main_block.find('input.return').val() == "") {                                                 
            $('#rentday').find('a').text("от "+ getMinOfArray(new_car_price_day) +" до "+ getMaxOfArray(new_car_price_day));
            $('#rentday').find('a').css("color" , "#5d5d5d");
            if ($("#select_type_rent").val() == "TRANSFER") {
                $('#rentres').find('a').text("Выберите дату подачи");    
            } else if ($("#select_type_rent").val() == 0) {
                $('#rentres').find('a').text("Выберите тип аренды");
            } else {
                $('#rentres').find('a').text("Выберите дату подачи/возврата");   
            }   
            $('#result').val(''); 
        }else{            
            if ($(this).hasClass("with")) {
                var input_delivery = main_block.find('input.delivery').val();
                var input_return = main_block.find('input.return').val();
                formatted_delivery = input_delivery.replace(/^(\d+).(\d+).(\d+) (\d+):(\d+):(\d+)/,"$3-$2-$1T$4:$5:$6");
                formatted_return = input_return.replace(/^(\d+).(\d+).(\d+) (\d+):(\d+):(\d+)/,"$3-$2-$1T$4:$5:$6")
                var ms_delivery = Date.parse(formatted_delivery); 
                var ms_return = Date.parse(formatted_return); 
                var ms_time = Math.abs(ms_return - ms_delivery);
                var days = Math.ceil(ms_time / (1000 * 3600 * 24));            
            } else if ($(this).hasClass("without")) {
                var input_delivery = main_block.find('input.delivery').val();
                var input_return = main_block.find('input.return').val();
                formatted_delivery = input_delivery.replace(/^(\d+).(\d+).(\d+)/,"$3-$2-$1");
                formatted_return = input_return.replace(/^(\d+).(\d+).(\d+)/,"$3-$2-$1")
                var ms_delivery = Date.parse(formatted_delivery); 
                var ms_return = Date.parse(formatted_return); 
                var ms_time = Math.abs(ms_return - ms_delivery);
                var days = Math.ceil(ms_time / (1000 * 3600 * 24)); 
            } 
            var i;
            selday = new_car_day;   
            selprice = new_car_price_day;
            $('#rentday').find('a').css("color" , "#5d5d5d");    
            for (i = 0; i<=selday.length-1 ; i+=2) {            
                if (selday[selday.length-2]<=days){                
                    $('#rentday').find('a').text(selprice[selprice.length-1]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text(days*selprice[selprice.length-1]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val(days*selprice[selprice.length-1]);
                    i = 0;                    
                    break;    
                }           
                if (selday[i] <= days && selday[i+1] >= days){
                    $('#rentday').find('a').text(selprice[i/2]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text(days*selprice[i/2]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val(days*selprice[i/2]);
                    i = 0;                    
                    break;    
                }
            }
            $("#days").val(days);
        }                                                   
    });   
    $("#select_city").change(function(){
        var cityid = $('#select_city option:selected').attr('value');
        res_car_city = '<option value="0" data_path="">Автомобиль</option>';
        res_airport = '<option value="0">Аэропорт</option>';
        res_ofice_delivery = '<option value="">Место подачи</option>';
        res_delivery = '<option value="address">Подать автомобиль по адресу...</option>';
        res_ofice_return = '<option value="">Место возврата</option>';
        res_return = '<option value="address">Вернуть автомобиль по адресу...</option>';
         $.ajax({
          url: "/local/templates/.default/ajax/change_city.php",
          type: "POST",
          data: {city: cityid},
          success: function(data){
                temp_res = $.secureEvalJSON(data);
                res_car_city +=  temp_res['CAR'];
                res_ofice_delivery += temp_res['OFFICE'];        
                res_ofice_return += temp_res['OFFICE'];
                res_airport += temp_res['AIRPORT'];        
            },
          async: false               
        });
        $("#select_car").html(res_car_city);
        $("#select_car_place_delivery").html(res_ofice_delivery);
        $("#select_car_place_delivery").append(res_delivery);
        $("#select_car_place_return").html(res_ofice_return);
        $("#select_car_place_return").append(res_return);
        $("#select_airport").html(res_airport);
        $("#select_car").change();        
    });
    $("#select_type_rent").change(function(){
        var typeid = $('#select_type_rent option:selected').attr('value');
        if (typeid == 'TRANSFER') {
            $(".transfer").css("display","block");
            $(".transfer").find('input').removeAttr('disabled');       
            $(".transfer").find('select').removeAttr('disabled');       
            $(".with_driver").css("display","none");
            $(".with_driver").find('input').attr('disabled','disabled');       
            $(".with_driver").find('select').attr('disabled','disabled');        
            $(".without_driver").css("display","none");
            $(".without_driver").find('input').attr('disabled','disabled');       
            $(".without_driver").find('select').attr('disabled','disabled');        
        } else if (typeid == 'WITH_DRIVER') {
            $(".transfer").css("display","none");
            $(".transfer").find('input').attr('disabled','disabled');       
            $(".transfer").find('select').attr('disabled','disabled'); 
            $(".with_driver").css("display","block");
            $(".with_driver").find('input').removeAttr('disabled');       
            $(".with_driver").find('select').removeAttr('disabled');
            $(".without_driver").css("display","none");
            $(".without_driver").find('input').attr('disabled','disabled');       
            $(".without_driver").find('select').attr('disabled','disabled');
        } else if (typeid == 'WITHOUT_DRIVER') {
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
        }
        $("#WITHOUT_DATE_RETURN, #WITH_DATE_RETURN, #WITHOUT_DATE_DELIVERY, #WITH_DATE_DELIVERY, #TRANSFER_DATE_RETURN").change();   
    });
    $("#select_car_place_delivery").change(function(){
        var carplaceid = $('#select_car_place_delivery option:selected').attr('value');
        if (carplaceid == 'address') {
            $(".address_delivery").val("");
            $(".address_delivery").css("display","block");
            $(".address_delivery").parent().css("display","block");
        } else {
            $(".address_delivery").css("display","none");
            $(".address_delivery").parent().css("display","none");
            $(".address_delivery").val($('#select_car_place_delivery option:selected').text());
        }
    });
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
    $("#direction_select_airport").change(function(){
        if($('#direction_select_airport option:selected').attr('value') == "IN"){
            $(".address_transfer").attr("placeholder","Адрес отправления");
        } else if ($('#direction_select_airport option:selected').attr('value') == "OUT") {
            $(".address_transfer").attr("placeholder","Адрес назначения");
        }
                
    });
    $(".form").find('.button').click(function(){
        $(".rentpost").submit();       
    }); 
});

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
//Нахождение максимальное число в ряде
function getMaxOfArray(numArray) {
  return Math.max.apply(null, numArray);
}
//Нахождение минимально число в ряде
function getMinOfArray(numArray) {
  return Math.min.apply(null, numArray);
}