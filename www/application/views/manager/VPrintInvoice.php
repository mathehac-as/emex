<?php if(isset($print_invoice)): ?>
<table class="print">
    <tr class="print_h3 print_center">
        <td rowspan="4"><img src="<?=$print_invoice['img']?>" class="print_img"/></td>
    </tr>
    <tr class="print_h3 print_center">
        <td colspan="2">Бланк заказа № <?=$print_invoice['id']?> от <?=$print_invoice['date_make']?></td>
    </tr>
    <tr class="print_h1 print_center">
        <td colspan="2"><b>Автозапчасти EMEX.RU</b></td>
    </tr>
    <tr class="print_bottom print_h4 print_center">
        <td colspan="2">ИП Хлопотов И.Н, ИНН 235209350233</td>
    </tr>
    <tr class="print_h4">
        <td>г.Темрюк, ул. Гагарина 255</td> 
        <td>ПН-СБ с 09.00 до 18.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тел. (988) 385-37-33</td>
    </tr>
    <tr class="print_h4">
        <td>г.Темрюк, ул.Степана Разина/ул.Ленина</td>
        <td>ПН-СБ с 09.00 до 18.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тел. (988) 320-12-32</td>
    </tr>
    <tr class="print_h4">
        <td> Добавить в накладную: г. Анапа Симферопольское ш.1а</td>
        <td>ПН-СБ с 10.00 до 19.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тел. (988) 317-04-25</td>
    </tr>
    <tr class="print_height20">
        <td colspan="2"></td>
    </tr>
    <tr class="print_h3">
        <td colspan="2" class="print_padding">Заказчик: <b><?=$print_invoice['fio']?></b></td>
    </tr>
    <tr class="print_h3">
        <td colspan="2" class="print_padding">Телефон: <b><?=$print_invoice['phone']?></b></td>
    </tr>
    <tr class="print_bottom_top print_h3">
        <td>Автомобиль: <b><?=$print_invoice['marka_avto']?></b></td>
        <td class="print_right">VIN: <b><?=$print_invoice['vin']?></b></td>
    </tr>
    <tr>
        <td colspan="2" class="print_h1 print_center"><b>Список заказанных запчастей</b></td>
    </tr>
    <tr class="print_all print_h3 print_center">
        <td colspan="2"><b>Описание</b></td>
    </tr>
    <tr class="print_all print_h3">
        <td colspan="2"><?=$print_invoice['comment']?></td>
    </tr>
    <tr class="print_all print_h3 print_right print_height_20">
        <td colspan="2"><b>Итого (руб.): <?=$print_invoice['sum']?> руб.</b></td>
    </tr>
    <tr class="print_bottom print_h3">
        <td><?php echo ($print_invoice['percent_discount'] != 0.00 ? 'Скидка: <b>'.$print_invoice['percent_discount'].'%</b>' : '');?></td>
        <td class="print_right">Срок поставки: <b><?=$print_invoice['delivery']?> дней</b></td>
    </tr>
    <tr class="print_bottom print_h3">
        <td>Оплачено: <b><?=$print_invoice['pay']?> руб.</b></td>
        <td class="print_right">Долг по оплате: <b><?=$print_invoice['debt']?> руб.</b></td>
    </tr>
    <tr class="print_bottom print_h3">
        <td>Сумма скидки: <b><?=(isset($discounthistory[0]['discount_sum']) ? $discounthistory[0]['discount_sum'] : 0)?> руб.</b></td>
        <td class="print_right">Дисконтная карта: <b>№<?=(isset($discounthistory[0]['discount_number']) ? $discounthistory[0]['discount_number']: '')?></b></td>
    </tr>
    <tr>
        <td colspan="2" class="print_h4"><b>Условия поставки:</b>
            Заказчик ознакомлен со стоимостью товара, условиями и сроками поставки. Стоимость и срок поставки могут меняться только после согласования с заказчиком.  
            Заказчик разрешает получать, хранить, обрабатывать персональные данные заказчика, а также производить иные действия, не противоречащие законодательству. 
            Согласие бессрочное. Персональные данные предоставлены добровольно. С условиями хранения персональных данных и возврата товара заказчик ознакомлен.
        </td>
    </tr>
    <tr class="print_height">
        <td colspan="2"></td>
    </tr>
    <tr class="print_h3 print_padding_top print_text_bottom">
        <td>Данные верны,<br>с условиями согласен:________________</td>
        <td>Исполнитель:________________</td>
    </tr>
    <tr class="print_h4 print_padding_bottom print_text_top">
        <td class="print_right print_padding_right">(подпись заказчика)</td>
        <td class="print_right print_padding_right">(подпись исполнителя)</td>
    </tr>
    <tr class="print_bottom print_height">
        <td colspan="2"></td>
    </tr>
</table>																
<?php endif; ?>
