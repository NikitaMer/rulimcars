<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "TEST");
$APPLICATION->SetTitle("TEST");?>

<table style="width:100%;margin:0;padding:0;">
<tr>
<td colspan="2">
    <div style="width:100%;padding-top: 54px;    display: flex;    align-items: center;    justify-content: center;        padding-left: 50px;    padding-bottom: 30px;    font-size: 20px;">
        <div class="top_contacts">
            <div style="color: #e93f45;">8 (800) 777 59 90</div>
            <div class="email">info@rulimcars.ru</div>
        </div>
        <div style="padding: 0 60px;">
            <a href="#SERVER_NAME#/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=site_logo"><img src="/img/logo.bmp" alt="" /></a>
        </div>
        <div class="top_address">Москва, Головинское <br>шоссе, д. 1, офис 318</div>
    </div>   
</td>
</tr>
        <tr>
            <td style="min-height: 570px;">
                Здравствуйте,  #NAME#! <br>
                Благодарим вас за обращение в компанию <a style="text-decoration: none;" href="#SERVER_NAME#/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=site_link"><span style="color: red;">RulimCars</span></a><br>
                Ваша заявка на бронирование успешно принята!<br>
                Номер вашей заявки <span style="color: red;">#TYPE_CAR_CIR##ID#</span>.<br>
                <br>
                Данные вашего бронирования: <br>
                <a style="text-decoration:none;" hreaf="#SERVER_NAME##DETAIL_CAR#/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=car_link"><span style="color: red;">#NAME_CAR# - #YEAR_CAR# г</span></a><br>
                Дата аренды: <span style="color: red;">#DATA#</span><br>
                Срок аренды: <span style="color: red;">#RENT#</span><br>
                Стоимость аренды: <span style="color: red;">#RESULT#.</span><br>
                Стоимость одних суток: <span style="color: red;">#RESULT_DAY#.</span><br>
                <br>
                Телефон: #PHONE#<br>
                e-mail: #EMAIL#<br>
                Комментарий:  #COMMENT#<br>
                <br>
            </td>                
            <td>
                <a href="#SERVER_NAME##DETAIL_CAR#/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=car_image"><img style="max-height: 470px;" src="#CAR_PICTURE#" alt=""></a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                В ближайшее время с вами свяжется наш менеджер по прокату, вы так же можете позвонить нам самостоятельно по бесплатному номеру <span style="color:red;">8 (800) 777 59 90</span> <br> <br>
            </td>
        </tr>
        <tr>
            <td style="background-color:#DFDFDF;" colspan="2">
                <ul style="display:block;display:flex;align-items:center;justify-content:center;">
                    <li style="list-style:none;float:left;display:block;height:50px;padding: 0 30px;position:relative;"><a style="display:block;height:18px;color:#000;font-size:21px;padding:16px 0;text-decoration:none;" href="#SITE_NAME#/services/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=uslugi">Услуги</a></li>
                    <li style="list-style:none;float:left;display:block;height:50px;padding: 0 30px;position:relative;"><a style="display:block;height:18px;color:#000;font-size:21px;padding:16px 0;text-decoration:none;" href="#SITE_NAME#/pay/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=infoplata">Способы оплаты</a></li>
                    <li style="list-style:none;float:left;display:block;height:50px;padding: 0 30px;position:relative;"><a style="display:block;height:18px;color:#000;font-size:21px;padding:16px 0;text-decoration:none;" href="#SITE_NAME#/contacts/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=aboutus">О компании</a></li>
                    <li style="list-style:none;float:left;display:block;height:50px;padding: 0 30px;position:relative;"><a style="display:block;height:18px;color:#000;font-size:21px;padding:16px 0;text-decoration:none;" href="#SITE_NAME#/contacts/?utm_source=order&utm_medium=email&utm_campaign=#ID#_#DATE_CREATE#&utm_content=contacts">Контакты</a></li>
                    <li style="list-style:none;float:left;display:block;height:50px;padding: 0 30px;position:relative;"><a style="display:block;height:18px;color:#000;font-size:21px;padding:16px 0;text-decoration:none;" href="https://vk.com/rulimcars"><img src="/img/rc_vk.png" alt=""></a></li>
                </ul>
            </td>
        </tr>
    </table>    

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>