$(document).ready(function () {
    $("input[name='PHONE']").mask("+7(999)999-99-99");
    var EmailCheck=/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,4}$/i;
    var Dat = new Date();
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
    $('#rentday').find('a').on("click",function(){  
        for(var i=0;i<2;i++){ 
            $('#select').fadeOut('slow').fadeIn('fast');
        }                                                                                                                           
    });
    $('#rentres').find('a').on("click",function(){
        for(var i=0;i<2;i++){
            $('#rent').fadeOut('slow').fadeIn('fast');    
        }                                                                                                                                 
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
* Код для Google Tag Manager при совершение заказа 
* @param NumOrder - Номер заказа
* @param Result - Цена заказа
* @param Coupon - номер купона
* @param CarName - Название автомобиля
* @param CarYear - Год автомобиля
* @param CarID - ID автомобиля
* @param ResultDay - Цена за один день
* @param Day - Кол-во дней
*/
function OrderCar(NumOrder, Result, Coupon, CarName, CarYear, CarID, ResultDay, Day){   
    dataLayer.push({
      'ecommerce': {
        'currencyCode': 'RUR',
        'purchase': {
          'actionField': {
            'id': NumOrder,        
            'revenue': Result,  
            'coupon': Coupon  
          },
          'products': [{                            
            'name': CarName+' '+CarYear,      
            'id': CarID,         
            'price': ResultDay,         
            'quantity': Day,           
            'coupon': Coupon
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