<?php if(isset($order_lists) && count($order_lists) > 0): ?>
<div class="bg_cont_list_orders">
    <div class="bg_cont_list_head">Список заказов</div>
    <?php foreach($order_lists as $val): ?>
    <div class="bg_cont_list_order_base">
        <div class="bg_cont_list_order_item">
            <div class="bg_cont_list_order_item_base">
                <div>Заказ: <b><?=$val['id']?></b> | 
                    <?php if(!isset($val['order_type_id']) || (int)$val['order_type_id'] != 1): ?>
                        <?php if(isset($order_lists_act['edit'])): ?>
                        <img src="<?=$order_lists_act['edit']['img']?>" title="<?=$order_lists_act['edit']['title']?>"
                             class="cursor_pointer" onclick="<?=$order_lists_act['edit']['js']?>" order_id="<?=$val['id']?>">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div><?=date('d.m.Y h:i:s', strtotime($val['date_create']))?></div>
                <div>Сумма заказа: <b><?=$val['sum']?></b> руб.</div>
                <div>Срок поставки: <b><?=$val['delivery']?></b> д.</div>
                <div>Баланс по заказу: 
                    <b<?=((int)$val['balance']<0?' style="color:red;"':((int)$val['balance']>0?' style="color:green;"':''))?>>
                        <?=$val['balance']?>
                    </b> руб.
                </div>
            </div>
            <div class="bg_cont_list_order_item_comment">
                <div><?=$val['comment']?></div>
            </div>
            <div class="clear_float"></div>
        </div>
        <div class="bg_cont_list_order_journal">
        <?php if(isset($journal_lists[$val['id']])): ?>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Основание</th>
                        <th>Сумма заказа</th>
                        <th>Дата</th>
                        <th>Менеджер</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($journal_lists[$val['id']] as $value): ?>
                    <tr journal_id="<?=$value['id']?>" class="<?=$value['color']?>">
                        <td><?=$value['id']?></td>
                        <td><?=$value['base']?><?=(!empty($value['comment']) ? '<br/>Комментарии: '.$value['comment'] : '')?></td>
                        <td><b><?=(isset($value['sum']) ? $value['sum'] : 0 )?></b> руб.</td>
                        <td><?=date('d.m.Y h:i:s', strtotime($value['date_history']))?></td>
                        <td><?=(isset($value['manager']) ? $value['manager'] : '' )?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="journal_total">Формы печати:</td>
                        <td>
                        <?php if(!isset($val['order_type_id']) || (int)$val['order_type_id'] != 1): ?>
                            <?php if(isset($order_lists_act['invoice'])): ?>
                            <a href="#" target="blank">
                                <img src="<?=$order_lists_act['invoice']['img']?>" title="<?=$order_lists_act['invoice']['title']?>" order_id="<?=$val['id']?>"
                                 class="cursor_pointer" onclick="<?=$order_lists_act['invoice']['js']?>">
                            </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <span class="bg_cont_nolist_order_journal">Нет записей</span>
        <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>            
</div>
<?php elseif(isset($order)): ?>
    <?php if(isset($act) && $act == 'edit'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$order['title']?></h4>
    </div>
    <div class="modal-body">
        <div class="order_tbody_lists">
            <input type="hidden" id="order_client_id" value="<?=$order['client_id']?>">
            <input type="hidden" id="order_order_id" value="<?=$order['id']?>">
            <input type="hidden" id="order_delta_balance" value="<?=$order['delta_balance']?>">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Комментарии</th>
                        <th>Кол-во</th>
                        <th>Стоемость (за ед.)</th>
                        <th>
                            <?php if(isset($order['js_add'])): ?>
                            <img src="<?=$order['img_add']?>" title="<?=$order['title_add']?>"
                                 class="cursor_pointer" onclick="<?=$order['js_add']?>">
                            <?php endif; ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="order_lists">
                        <td order_cod="order_number">1</td>
                        <td>
                            <textarea class="form-control input-sm-min" order_cod="order_comment"><?=$order['comment']?></textarea>
                        </td>
                        <td><input class="form-control input-sm-min" order_cod="order_count" value="1" readonly
                                onkeyup="setOrderAllSum()" placeholder="Кол-во"></td>
                        <td><input class="form-control input-sm-min" order_cod="order_sum" value="<?=$order['sum']?>" 
                                onkeyup="setOrderAllSum()" placeholder="Сумма заказа"></td>
                        <td></td>
                    </tr>
                    <tr class="order_item" style="display: none">
                        <td order_cod="order_number">1</td>
                        <td><textarea class="form-control input-sm-min" order_cod="order_comment"></textarea></td>
                        <td>
                            <input class="form-control input-sm-min" order_cod="order_count" value="1"
                                onkeyup="setOrderAllSum()" placeholder="Кол-во">
                        </td>
                        <td>
                            <input class="form-control input-sm-min" order_cod="order_sum"
                                onkeyup="setOrderAllSum()" placeholder="Сумма заказа">
                        </td>
                        <td>
                            <?php if(isset($order['js_del'])): ?>
                            <img src="<?=$order['img_del']?>" title="<?=$order['title_del']?>" 
                                 class="cursor_pointer" onclick="<?=$order['js_del']?>">
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="order_total">
            <div class="order_delivery_time">
                Срок поставки 
                <input class="form-control input-sm-min" order_cod="order_delivery_time" value="<?=$order['delivery']?>"> дней
            </div>
            <div class="order_percent_discount">
                Процент скидки 
                <input class="form-control input-sm-min" order_cod="order_percent_discount" 
                       value="<?=$order['percent_discount']?>"> %
            </div>
            <div class="order_all_sum">
                Общая сумма 
                <input class="form-control input-sm-min" value="<?=$order['sum']?>" order_cod="order_all_sum" readonly>
            </div>
            <div class="clear_float"></div>
            <div class="order_sub_comment">
                Комментарии 
                <textarea class="form-control input-sm-min" order_cod="order_sub_comment"></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$order['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else:?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>