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
            $('#select').fadeOut('slow').fadeIn('fast');
        }                                                                                                                           
    });
    // мигание селектора для выбора дня
    $('#rentres').find('a').on("click",function(){
        for(var i=0;i<2;i++){
            $('#rent').fadeOut('slow').fadeIn('fast');    
        }                                                                                                                                 
    });
    $("#select").click(function(){
        oldcarid = $('#select option:selected').attr('value');     
    });
    $("#select").change(function(){
        var newcarid = $('#select option:selected').attr('value');
        var src = $('#select option:selected').attr('data_path');       
        $('#selectimg').find('img').attr("src",$('#select option:selected').attr('data_path'));
        
        $.ajax({
          url: "/local/templates/.default/ajax/car_pic.php",
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
        $.each(res['NEW_CAR']['PRICES'],function(index,value) {            
            new_car[value['TYPE_RENT']] = value['OFFER'];                                                     
        });
        $.each(new_car['DAY'],function(index,value) {            
            new_car_price_day.push(Number(value['PRICE']));                                                      
        });
        $.each(new_car['HOUR'],function(index,value) {            
            new_car_price_hour.push(Number(value['PRICE']));                                                      
        });                                    
        if(res['OLD_CAR']){
            old_car = new Array(); 
            $.each(res['OLD_CAR']['PRICES'],function(index,value) {            
                old_car[value['TYPE_RENT']] = value['OFFER'];                                                      
            });
            ChangeCar(newcarid, res['NEW_CAR']['NAME'], res['NEW_CAR']['YEAR'], new_car['DAY'][0]['PRICE'], oldcarid, res['OLD_CAR']['NAME'], res['OLD_CAR']['YEAR'], old_car['За сутки'][0]['PRICE']);           
        }else{
            ChangeCar(newcarid, res['NEW_CAR']['NAME'], res['NEW_CAR']['YEAR'], new_car['DAY'][0]['PRICE'], 0, null, null, 0);           
        }  
        console.log(new_car_price_day);
        $("#rent").change();
    });
    $("#rent").change(function(){ 
        if(($("#select").val() == "0" && $("#rent").val() == "0") || $("#select").val() == "0"){
           $('#rentday').find('a').text("Выберите автомобиль");
           $('#rentday').find('a').css("color" , "#e93f45");  
           $('#rentres').find('a').text("Выберите срок аренды");   
           $('#result').val('');   
        }else if ($("#rent").val() == "0"){                                                 
            $('#rentday').find('a').text("от "+ getMinOfArray(new_car_price_day) +" до "+ getMaxOfArray(new_car_price_day));
            $('#rentday').find('a').css("color" , "#5d5d5d");
            $('#rentres').find('a').text("Выберите срок аренды");   
            $('#result').val(''); 
        }/*else{
            var i;
            selday = car[$('#select option:selected').attr('value')]['Day'];   
            selprice = car[$('#select option:selected').attr('value')]['Price'];
            $('#rentday').find('a').css("color" , "#5d5d5d");    
            for (i = 0; i<=selday.length-1 ; i+=2) {            
                if (selday[selday.length-2]<=Number($("#rent").val())){                
                    $('#rentday').find('a').text(selprice[selprice.length-1]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text($("#rent").val()*selprice[selprice.length-1]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val($("#rent").val()*selprice[selprice.length-1]);
                    i = 0;                    
                    break;    
                }           
                if (selday[i] <= Number($("#rent").val()) && selday[i+1] >= Number($("#rent").val())){
                    $('#rentday').find('a').text(selprice[i/2]);                     
                    $('#rentday').find('a').append("<span>&#8381;</span>");  
                    $('#rentres').find('a').text($("#rent").val()*selprice[i/2]);
                    $('#rentres').find('a').append("<span>&#8381;</span>");
                    $('#result').val($("#rent").val()*selprice[i/2]);
                    i = 0;                    
                    break;    
                }
            }
        } */                                              
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