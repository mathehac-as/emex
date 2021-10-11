<?php if(isset($discounthistorys) && count($discounthistorys) > 0): ?>
<div class="bg_cont_list_discounthistorys">
    <div class="bg_cont_list_head">
        История
        <?php if(isset($discounthistorys_act['clear']) && isset($accesses) && in_array(2, $accesses)): ?>
        <img src="<?=$discounthistorys_act['clear']['img']?>" title="<?=$discounthistorys_act['clear']['title']?>" 
            class="cursor_pointer" onclick="<?=$discounthistorys_act['clear']['js']?>">
        <?php endif; ?>
    </div>
    <div class="bg_cont_list_discounthistorys_base">
        <div class="bg_cont_list_discounthistorys_journal"> 
            <table class="table table-condensed">
                <thead>
                    <tr class="discounthistorys_head">
                        <th>Комментарий</th>
                        <th>Дата</th>
                        <th>ФИО заказчика</th>
                        <th>Процент</th>
                        <th>Сумма заказа</th>
                        <th>Сумма скидки</th>
                        <th>Бонусы</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($discounthistorys as $key => $val): ?>
                    <tr>
                        <td><?=$val['dh_comment']?></td>
                        <td><?=date('d.m.Y h:i:s', strtotime($val['dh_date_create']))?></td>
                        <td><?=(isset($val['client_fio']) ? $val['client_fio'] : '' )?></td>
                        <td><?=$val['dh_percent']?>%</td>
                        <td><?=(isset($val['dh_order_sum']) ? $val['dh_order_sum'] : 0 )?> руб.</td>
                        <td><b><?=(isset($val['dh_discount_sum']) ? $val['dh_discount_sum'] : 0 )?></b> руб.</td>
                        <td><b><?=(isset($val['dh_bonus']) ? $val['dh_bonus'] : 0 )?></b></td>
                    </tr>
                <?php endforeach;?>
                    <tr class="discounthistorys_sum">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?=(isset($discounthistorys_sum[0]['order_sum']) ? $discounthistorys_sum[0]['order_sum'] : 0 )?> руб.
                        </td>
                        <td>
                            <b>
                                <?=(isset($discounthistorys_sum[0]['discount_sum']) ? $discounthistorys_sum[0]['discount_sum'] : 0 )?>
                            </b> руб.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>