<div id="bg_cont_journal_list">
<?php if(isset($journals)):?>
    <?php if((!isset($journals['office_historys']) || count($journals['office_historys']) == 0)
            && (!isset($journals['order_historys']['order_lists']) 
            || count($journals['order_historys']['order_lists']) == 0)):?>
     <div class="alert alert-info alert-min">Нет операций</div>
     <?php else: ?>
        <?php if(count($journals['office_historys']) > 0): ?>
        <table class="table table-condensed">
            <tbody>
                <?php if (isset($journals['office_historys'])): ?>
                    <?php foreach ($journals['office_historys'] as $value): ?>
                        <?php if($value['type_history'] == 'outcash'): ?>
                        <tr class="bg_cont_office_historys_outcash">
                            <td><span>Инкассация: <b><?=$value['sum']?></b> руб.</span>
                            | <span><?=date('d.m.Y', strtotime($value['date_change']))?></span>
                            | <span><?=$value['comment']?></span>
                            | <span><?=$value['fio']?></span>
                            </td>
                        </tr>
                        <?php elseif($value['type_history'] == 'incash'): ?>
                        <tr class="bg_cont_office_historys_incash">
                            <td><span>Внесено в кассу: <b><?=$value['sum']?></b> руб.</span>
                            | <span><?=date('d.m.Y', strtotime($value['date_change']))?></span>
                            | <span><?=$value['comment']?></span>
                            | <span><?=$value['fio']?></span>
                            </td>
                        </tr>
                        <?php elseif($value['type_history'] == 'correction'): ?>
                        <tr class="bg_cont_office_historys_correction">
                            <td><span>Коррекция: <b><?=$value['sum']?></b> руб.</span>
                            | <span><?=date('d.m.Y', strtotime($value['date_change']))?></span>
                            | <span><?=$value['comment']?></span>
                            | <span><?=$value['fio']?></span>
                            </td>
                        </tr>
                        <?php elseif($value['type_history'] == 'coins_add'): ?>
                        <tr class="bg_cont_office_historys_coins_add">
                            <td><span>Пополнение баланса: <b><?=$value['sum']?></b> руб.</span>
                            | <span><?=date('d.m.Y', strtotime($value['date_change']))?></span>
                            | <span><?=$value['comment']?></span>
                            | <span><?=$value['fio']?></span>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php endif; ?>
        <?php if(count($journals['order_historys']['order_lists']) > 0): ?>
            <?php foreach($journals['order_historys']['order_lists'] as $val): ?>
            <div class="bg_cont_list_order_base">
                <div class="bg_cont_list_order_item">
                    <div class="bg_cont_list_order_item_base">
                        <div>Заказ: <b><?=$val['order_id']?></b> | <?=date('d.m.Y h:i:s', strtotime($val['order_date_create']))?></div>
                        <div>Сумма заказа: <b><?=$val['order_sum']?></b> руб.</div>
                        <div>Баланс по заказу: <b><?=$val['order_balance']?></b> руб.</div>
                    </div>
                    <div class="bg_cont_list_order_item_comment">
                        <div><?=$val['fio']?></div>
                    </div>
                    <div class="clear_float"></div>
                </div>
                <div class="bg_cont_list_order_journal">
                <?php if(isset($journals['order_historys']['journal_lists'][$val['order_id']])): ?>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Основание</th>
                                <th>Сумма заказа</th>
                                <th>Дата</th>
                                <th>Менеджер</th>
                                <th>Опции</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($journals['order_historys']['journal_lists'][$val['order_id']] as $value): ?>
                                <tr journal_id="<?=$value['id']?>" class="<?=$value['color']?>">
                                    <td><?=$value['id']?></td>
                                    <td><?=$value['base']?><?=(!empty($value['comment']) ? '<br/>Комментарии: '.$value['comment'] : '')?></td>
                                    <td><b><?=(isset($value['sum']) ? $value['sum'] : 0 )?></b> руб.</td>
                                    <td><?=date('d.m.Y', strtotime($value['date_history']))?></td>
                                    <td><?=(isset($value['manager']) ? $value['manager'] : '' )?></td>
                                    <td><a href="#" target="blank"><button type="button" class="btn btn-primary btn-xs"
                                                onclick="getPrintOrder(this)">Пр. ордер</button></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <span class="bg_cont_nolist_order_journal">Нет записей</span>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>  
        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php else: ?>
        <div class="alert alert-info alert-min">Не выбрана дата</div>
    <?php endif;?>
<?php endif; ?>
</div>

