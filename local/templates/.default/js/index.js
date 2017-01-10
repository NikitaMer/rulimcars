$(document).ready(function () {
    $("input[name='PHONE']").mask("+7(999)999-99-99");
    
    $("#select").change(function(){
        location.href = "/rent/?AUTO=" + $('#select option:selected').attr('value');
    });
    var Data = new Date();    
    Tomorrow = new Date(Data.getTime() + (24 * 60 * 60 * 1000));
    dayTomorrow = Tomorrow.getDate(); 
    monthTomorrow = Tomorrow.getMonth() + 1; //в js месяц отсчитывается с нуля
    yearTomorrow = Tomorrow.getFullYear();
    if (dayTomorrow<10){dayTomorrow = '0'+dayTomorrow;}
    if (monthTomorrow<10){monthTomorrow = '0'+monthTomorrow;}
    $('#date_fld').val(dayTomorrow +'.'+monthTomorrow+'.'+yearTomorrow);
    $('#copyright').find('span').text(yearTomorrow);    
    $("#rent").change(function(){
        
        var selday, selprice; 
        $('#selday').each(function(){
            selday = $(this).text().match(/\d+/g);                
        });
        $('#selprice').each(function(){
            selprice = $(this).text().match(/\d+/g);                
        });
        var i;
        if ($("#rent").val() === "0"){            
           $('#rentday').find('a').text(" ");
           $('#rentres').find('a').text(" ");   
           $('#result').val('');   
        }
        for (i = 0; i <= selday.length; i+=2) {            
            if (selday[selday.length-1]<=Number($("#rent").val())){                
                $('#rentday').find('a').text(selprice[selprice.length-1]);                     
                $('#rentday').find('a').append("<span>&#8381;</span>");  
                $('#rentres').find('a').text($("#rent").val()*selprice[selprice.length-1]);
                $('#rentres').find('a').append("<span>&#8381;</span>");
                $('#result').val($("#rent").val()*selprice[selprice.length-1]);
                break;    
            }           
            if (selday[i] <= Number($("#rent").val()) && selday[i+1] >= Number($("#rent").val())){
                $('#rentday').find('a').text(selprice[i/2]);                     
                $('#rentday').find('a').append("<span>&#8381;</span>");  
                $('#rentres').find('a').text($("#rent").val()*selprice[i/2]);
                $('#rentres').find('a').append("<span>&#8381;</span>");
                $('#result').val($("#rent").val()*selprice[i/2]);
                break;    
            }
        }
    });
    $("input.must").focus(function(){
        var el = $(this), val = el.val();               
        if (val.indexOf("Заполните ") == 0) {
            $(this).val("");
        }        
        $(this).parent().removeClass("nogood");
        $(this).removeClass("nogood");
    });
    $("form").submit(function(){        
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
        if (br == "yes") {            
            return false;
        }

        //если блокировка отправки не сработала, то запускаем аякс, который отправляет письмо на почту
        else {                 
            $.post("/local/templates/.default/ajax/send.php", {  
                AUTO: $('#select').val(),
                NAME: $('#name').val(),
                RENT: $('#rent').val(),
                RESULT: $('#result').val(),
                DATE: $('#date_fld').val(),
                PHONE: $('#phone').val(),
                EMAIL: $('#email').val(),
                TEXT: $('#text').val(),
                }, function(data){
                    data = data.trim();
                    if (data == "OKOK") {
                        return true;
                    }else {
                        alert("Произошла ошибка! Проверьте правильность введенных данных и попробуйте снова.");
                        return false;
                    }
            });
        }        
    });
});