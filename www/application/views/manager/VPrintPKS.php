<?php if(isset($print_cash_register)): ?>
<table class="print_all2">
    <tr>
        <td>
            <table class="print">
                <tr class="print_h4"><td class="print_padding400">Унифицированная форма № КО-1</td></tr>
                <tr class="print_h4"><td class="print_padding400">Утверждена постановлением Госкомстата</td></tr>
                <tr class="print_h4"><td class="print_padding400">России от 18.08.98 г. № 88</td></tr>
                <tr class="print_height"><td></td></tr>
            </table>
            <table class="print">
                <tr class="print_h3">
                    <td colspan="7"></td>
                    <td colspan="2" class="print_border print_center print_width100">Код</td>
                </tr>
                <tr class="print_h3">
                    <td colspan="5"></td>
                    <td class="print_right print_padding_right10">Форма по ОКУД</td>
                    <td></td>
                    <td colspan="2" class="print_border print_center print_width100">0310001</td>
                </tr>
                <tr class="print_h3">
                    <td colspan="5" class="print_bottom print_center">ИП Хлопотов И.Н, ИНН 235209350233</td>
                    <td class="print_right print_padding_right10">по ОКПО</td>
                    <td></td>
                    <td colspan="2" class="print_border print_width100"></td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top">
                    <td colspan="6" class="print_center print_padding_right">организация</td>
                    <td></td>
                    <td colspan="2" class="print_border print_width100" rowspan="2"></td>
                </tr>
                <tr class="print_h3">
                    <td colspan="6" class="print_bottom print_center print_padding_right">&nbsp;</td>
                    <td></td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top">
                    <td colspan="6" class="print_center print_padding_right">структурное подразделение</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print">
                <tr class="print_h3 print_padding_bottom print_text_top print_center">
                    <td></td>
                    <td class="print_border print_width100">Номер документа</td>
                    <td class="print_border print_width100">Дата составления</td>
                </tr>
                <tr class="print_h3 print_text_top print_center">
                    <td class="print_bold">ПРИХОДНЫЙ КАССОВЫЙ ОРДЕР</td>
                    <td class="print_border print_width100"><?=$print_cash_register['number']?></td>
                    <td class="print_border print_width100"><?=$print_cash_register['date_make']?></td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print">
                <tr class="print_h3 print_center print_text_central">
                    <td class="print_border print_width100" rowspan="2">Дебет</td>
                    <td class="print_border" colspan="4">Кредит</td>
                    <td class="print_border print_width100" rowspan="2">Сумма, руб. коп.</td>
                    <td class="print_border print_width100" rowspan="2">Код целевого назначения</td>
                    <td class="print_border print_width100" rowspan="2"></td>
                </tr>
                <tr class="print_h3 print_center print_text_central">
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100">код структурного подразделения</td>
                    <td class="print_border print_width100">корреспон-дирующий счет, субсчет</td>
                    <td class="print_border print_width100">код аналитичес- кого учета</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"><?=$print_cash_register['sum']?></td>
                    <td class="print_border print_width100"></td>
                    <td class="print_border print_width100"></td>
                </tr> 
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print">
                <tr class="print_h3 print_center">
                    <td class="print_width print_left">Принято от</td>
                    <td class="print_bottom"><?=$print_cash_register['fio']?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_width print_left">Основание:</td>
                    <td class="print_bottom">
                        Заказ № <?=$print_cash_register['number']?> от <?=$print_cash_register['date']?> года
                    </td>
                </tr>
                <tr class="print_h3 print_bottom">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_width print_left">Сумма:</td>
                    <td class="print_bottom"><?=$print_cash_register['sum']?></td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top">
                    <td>&nbsp;</td>
                    <td colspan="2" class="print_center">прописью</td>
                </tr>
            </table>
            <table class="print">
                <tr class="print_h3 print_bottom">
                    <td colspan="2" class="print_padding450">
                        руб.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;коп.
                    </td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_width print_left">В том числе</td>
                    <td class="print_bottom">&nbsp;</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_width print_left">Приложение</td>
                    <td class="print_bottom">&nbsp;</td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print">
                <tr class="print_h3 print_center">
                    <td class="print_width150 print_left">Главный бухгалтер</td>
                    <td class="print_bottom print_width150">&nbsp;</td>
                    <td class="print_width10">&nbsp;</td>
                    <td class="print_bottom print_width150">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top">
                    <td>&nbsp;</td>
                    <td class="print_center">(подпись)</td>
                    <td>&nbsp;</td>
                    <td class="print_center">(расшифровка подписи)</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_width150 print_left">Получил кассир</td>
                    <td class="print_bottom print_width150">&nbsp;</td>
                    <td class="print_width10">&nbsp;</td>
                    <td class="print_bottom print_width150">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top">
                    <td>&nbsp;</td>
                    <td class="print_center">(подпись)</td>
                    <td>&nbsp;</td>
                    <td class="print_center">(расшифровка подписи)</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_h3 print_padding_bottom print_text_bottom print_height">
                    <td class="print_width150 print_left">Новости/Акции</td>
                    <td class="print_center"><?=$print_cash_register['news']?></td>
                </tr>
            </table>
        </td>
        <td></td>
        <td class="print_left_right print_width10">&nbsp;</td>
        <td></td>
        <td>
            <table class="print350 print_center">
                <tr class="print_height20"><td></td></tr>
                <tr class="print_h3"><td class="print_bottom">ИП Хлопотов И.Н, ИНН 235209350233</td></tr>
                <tr class="print_h4 print_padding_bottom print_text_top"><td>организация</td></tr>
                <tr class="print_height20"><td></td></tr>
                <tr class="print_h1">
                    <td>
                        <table>
                            <tr>
                                <td rowspan="4"><img src="<?=$print_cash_register['img']?>" class="print_img"/></td>
                                <td><b>КВИТАНЦИЯ</b></td>
                            </tr>
                            <tr class="print_h5 print_left">
                                <td>г. Темрюк, ул. Гагарина 255 (988)385-37-33</td>
                            </tr>
                            <tr class="print_h5 print_left">
                                <td>г. Темрюк ул.Ленина/Ст.Разина (988)320-12-32</td>
                            </tr>
                            <tr class="print_h5 print_left">
                                <td>г. Анапа Симферопольское ш.1а (988)317-04-25</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="print_height"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_left">к приходному кассовому ордеру №</td>
                    <td class="print_bottom print_width100">№<?=$print_cash_register['number']?></td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_left print_width20">от</td>
                    <td class="print_bottom"><?=$print_cash_register['date_make']?></td>
                    <td class="print_width10">г.</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_left print_width80">Принято от</td>
                    <td class="print_bottom"><?=$print_cash_register['fio']?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td colspan="2" class="print_bottom">&nbsp;</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width80">Основание:</td>
                    <td class="print_bottom">
                        Заказ № <?=$print_cash_register['number']?> от <?=$print_cash_register['date']?> г.
                    </td>
                </tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Общая сумма заказа:</td>
                    <td class="print_bottom"><?=$print_cash_register['sum']?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Получено:</td>
                    <td class="print_bottom"><?=$print_cash_register['pay']?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Остаток по заказу:</td>
                    <td class="print_bottom"><?=$print_cash_register['debt']?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Срок доставки:</td>
                    <td class="print_bottom"><?=$print_cash_register['delivery']?></td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_left print_width100">Сумма скидки: </td>
                    <td colspan="4" class="print_bottom">
                        <?=(isset($discounthistory[0]['discount_sum']) ? $discounthistory[0]['discount_sum'] : 0)?> руб. 
                        (<?=(isset($discounthistory[0]['discount_percent']) ? $discounthistory[0]['discount_percent'] : 0)?>%)</td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Начисленные баллы: </td>
                    <td colspan="4" class="print_bottom"><?=(isset($print_cash_register['bonus_writeoff']) ? $print_cash_register['bonus_writeoff'] : 0)?></td>
                </tr>
                <tr class="print_h3 print_center">
                    <td class="print_left print_width150">Списанные баллы: </td>
                    <td colspan="4" class="print_bottom"><?=(isset($print_cash_register['bonus_sum']) ? $print_cash_register['bonus_sum'] : 0)?></td>
                </tr>
                <tr class="print_height20"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_bottom print_width150"><?=$print_cash_register['date_make']?></td>
                    <td class="print_width10">г.</td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="print_height20"><td></td></tr>
                <tr class="print_h3 print_center">
                    <td colspan="7" class="print_left print_padding">М. П. (штампа)</td>
                </tr>
                <tr class="print_height30"><td></td></tr>
            </table>
            <table class="print350">
                <tr class="print_h3 print_center">
                    <td class="print_width150">Менеджер:</td>
                    <td class="print_bottom print_width70">&nbsp;</td>
                    <td class="print_width10"></td>
                    <td class="print_bottom print_width140">&nbsp;</td>
                </tr>
                <tr class="print_h4 print_padding_bottom print_text_top print_center">
                    <td class="print_width150"></td>
                    <td class="print_width70">(подпись)</td>
                    <td class="print_width10"></td>
                    <td class="print_width140">(расшифровка подписи)</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php endif; ?>
