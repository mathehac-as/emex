<?php if(isset($print_coins)): ?>
<table class="print">
    <tr class="print_h3 print_center">
        <td colspan="2">Бланк пополнения баланса № <?=$print_coins['order_id']?> от <?=date('d.m.Y')?></td>
    </tr>
    <tr class="print_h1 print_center">
        <td colspan="2"><b>Автозапчасти EMEX.RU</b></td>
    </tr>
    <tr class="print_bottom print_h4 print_center">
        <td colspan="2">ИП Хлопотов И.Н, ИНН 235209350233</td>
    </tr>
    <tr class="print_h3">
        <td colspan="2" class="print_padding">Заказчик: <b><?=$print_coins['fio']?></b></td>
    </tr>
    <tr class="print_h3">
        <td class="print_padding">Телефон: <b><?=$print_coins['phone']?></b></td>
         <td class="print_padding">ID: <b><?=$print_coins['id']?></b></td>
    </tr>
    <tr class="print_all print_h3 print_center">
        <td class="print_width"><b>Наименование услуги</b></td>
        <td><b>Сумма</b></td>
    </tr>
    <tr class="print_all print_h3">
        <td><?=$print_coins['comment']?></td>
        <td class="print_center"><?=$print_coins['sum']?> руб.</td>
    </tr>
    <tr class="print_all print_h3 print_right print_height_20">
        <td colspan="2"><b>Оплачено: <?=$print_coins['sum']?> руб.</b></td>
    </tr>
    <tr>
        <td colspan="2" class="print_h4"><b>Условия пополнения баланса:</b>
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
