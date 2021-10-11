<?php if(isset($errors)):?>
    <div class="alert alert-danger alert-min"><?=$errors?></div>
<?php elseif(isset($msg)):?>
    <div class="alert alert-success alert-min"><?=$msg?></div>
<?php endif;?>
<?php if(isset($order_lists)): ?>
<div class="bg_cont_list_orders">
    <div class="bg_cont_list_head manager_list_head">
        Список заказов
        <?php if(isset($order_lists_act['add']) && isset($accesses) && in_array(6, $accesses)): ?>
        <img src="<?=$order_lists_act['add']['img']?>" title="<?=$order_lists_act['add']['title']?>" class="cursor_pointer"
             onclick="<?=$order_lists_act['add']['js']?>">
        <?php endif; ?>
        <?php if(isset($order_lists_act['refresh'])): ?>
        <img src="<?=$order_lists_act['refresh']['img']?>" title="<?=$order_lists_act['refresh']['title']?>"
             class="cursor_pointer" onclick="<?=$order_lists_act['refresh']['js']?>">
        <?php endif; ?>
        <?php if(isset($order_lists_act['coins_add'])): ?>
        <img src="<?=$order_lists_act['coins_add']['img']?>" title="<?=$order_lists_act['coins_add']['title']?>"
             class="cursor_pointer" onclick="<?=$order_lists_act['coins_add']['js']?>">
        <?php endif; ?>
    </div>
    <?php foreach($order_lists as $val): ?>
    <div class="bg_cont_list_order_base">
        <div class="bg_cont_list_order_item">
            <div class="bg_cont_list_order_item_base">
                <div>
                    Заказ: <b><?=$val['id']?></b> | 
                    <?php if(!isset($val['order_type_id']) || (int)$val['order_type_id'] != 1): ?>
                        <?php if(isset($order_lists_act['edit']) && isset($accesses) && in_array(14, $accesses)): ?>
                        <img src="<?=$order_lists_act['edit']['img']?>" title="<?=$order_lists_act['edit']['title']?>"
                             class="cursor_pointer" onclick="<?=$order_lists_act['edit']['js']?>" order_id="<?=$val['id']?>">
                        <?php endif; ?>
                        <?php if(!isset($val['journal_type']) || (int)$val['journal_type'] == 0): ?>
                            <?php if(isset($order_lists_act['shipping'])): ?>
                            <img src="<?=$order_lists_act['shipping']['img']?>" title="<?=$order_lists_act['shipping']['title']?>"
                                 class="cursor_pointer" onclick="<?=$order_lists_act['shipping']['js']?>" order_id="<?=$val['id']?>">
                            <?php endif; ?>
                            <?php if(isset($order_lists_act['credit_card'])): ?>
                            <img src="<?=$order_lists_act['credit_card']['img']?>" title="<?=$order_lists_act['credit_card']['title']?>"
                                 class="cursor_pointer" onclick="<?=$order_lists_act['credit_card']['js']?>" order_id="<?=$val['id']?>">
                            <?php endif; ?> 
                            <?php if(isset($order_lists_act['credit_bonus']) && isset($accesses) && in_array(12, $accesses)): ?>
                            <img src="<?=$order_lists_act['credit_bonus']['img']?>" title="<?=$order_lists_act['credit_bonus']['title']?>"
                                 class="cursor_pointer" onclick="<?=$order_lists_act['credit_bonus']['js']?>" order_id="<?=$val['id']?>">
                            <?php endif; ?> 
                            <?php if(isset($order_lists_act['send_sms'])): ?>
                            <img src="<?=$order_lists_act['send_sms']['img']?>" title="<?=$order_lists_act['send_sms']['title']?>"
                                 class="cursor_pointer" onclick="<?=$order_lists_act['send_sms']['js']?>" order_id="<?=$val['id']?>">
                            <?php endif; ?> 
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div>Дата заказа: <?=date('d.m.Y h:i:s',strtotime($val['date_create']))?></div>
                <div>Сумма заказа: <b><?=$val['sum']?></b> руб.</div>
                <div>Срок поставки: <b><?=$val['delivery']?></b> д.</div>
                <div>Баланс по заказу: 
                    <b<?=((int)$val['balance']<0?' style="color:red;"':((int)$val['balance']>0?' style="color:green;"':''))?>>
                        <?=$val['balance']?>
                    </b> руб.
                </div>
                <div class="oreng_block">№ заказа ABCP: <b><?=$val['abcp_number']?></b></div>
            </div>
            <div class="bg_cont_list_order_item_comment_manager">
                <div><?=(!empty($val['comment']) ? $val['comment'] : '-')?></div>
            </div>
            <div class="bg_cont_list_order_item_btn">
                <?php if(!isset($val['order_type_id']) || (int)$val['order_type_id'] != 1): ?>
                    <?php if(isset($accesses) && in_array(7, $accesses)): ?>
                    <button type="button" class="btn btn-primary btn-xs" order_id="<?=$val['id']?>"
                        onclick="getOrderCash(this, 'incash')">В кассу</button>
                    <?php endif; ?>
                    <?php if(isset($accesses) && in_array(8, $accesses)): ?>
                    <button type="button" class="btn btn-primary btn-xs" order_id="<?=$val['id']?>"
                        onclick="getOrderCash(this, 'outcash')">Из кассы</button>
                    <?php endif; ?>
                    <?php if(isset($accesses) && in_array(9, $accesses)): ?>
                    <button type="button" class="btn btn-primary btn-xs" order_id="<?=$val['id']?>"
                        onclick="getOrderCash(this, 'card')">Оплачено картой</button>
                    <?php endif; ?>
                    <?php if(isset($accesses) && in_array(15, $accesses)): ?>
                    <button type="button" class="btn btn-primary btn-xs" order_id="<?=$val['id']?>"
                        onclick="getOrderCash(this, 'transfer')">Переводом на карту</button>
                    <?php endif; ?>
                <?php endif; ?>
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
                            <td><?=date('d.m.Y h:i:s',strtotime($value['date_history']))?></td>
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
                                <?php if(isset($order_lists_act['cash_register'])): ?>
                                <a href="#" target="blank">
                                    <img src="<?=$order_lists_act['cash_register']['img']?>" title="<?=$order_lists_act['cash_register']['title']?>" order_id="<?=$val['id']?>"
                                     class="cursor_pointer" onclick="<?=$order_lists_act['cash_register']['js']?>">
                                </a>
                                <?php endif; ?>
                                <?php if(isset($order_lists_act['cash_register_fast'])): ?>
                                <a href="#" target="blank">
                                    <img src="<?=$order_lists_act['cash_register_fast']['img']?>" title="<?=$order_lists_act['cash_register_fast']['title']?>" order_id="<?=$val['id']?>"
                                     class="cursor_pointer" onclick="<?=$order_lists_act['cash_register_fast']['js']?>">
                                </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(isset($order_lists_act['print_coins'])): ?>
                                <a href="#" target="blank">
                                    <img src="<?=$order_lists_act['print_coins']['img']?>" title="<?=$order_lists_act['print_coins']['title']?>" order_id="<?=$val['id']?>"
                                     class="cursor_pointer" onclick="<?=$order_lists_act['print_coins']['js']?>">
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
    <?php if(isset($act) && $act == 'add'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">
            <?=$order['title']?>
            <?php if(isset($order['js_add_auto'])): ?>
            <img src="<?=$order['img_add_auto']?>" title="<?=$order['title_add_auto']?>"
                 class="cursor_pointer" onclick="<?=$order['js_add_auto']?>">
            <?php endif; ?>
            <?=$order['title_abcp']?>
            <?php if(isset($order['js_add_abcp'])): ?>
            <img src="<?=$order['img_add_abcp']?>" title="<?=$order['title_abcp']?>"
                 class="cursor_pointer" onclick="<?=$order['js_add_abcp']?>">
            <?php endif; ?>
        </h4>
    </div>
    <div class="modal-body">
        <div class="order_tbody_lists">
            <input type="hidden" id="order_client_id" value="<?=$order['client_id']?>">
            <input type="hidden" id="order_abcp_id" value="">
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
                        <td><textarea class="form-control input-sm-min" order_cod="order_comment"></textarea></td>
                        <td><input class="form-control input-sm-min" order_cod="order_count" value="1" 
                                onkeyup="setOrderAllSum()" placeholder="Кол-во"></td>
                        <td><input class="form-control input-sm-min" order_cod="order_sum" 
                                onkeyup="setOrderAllSum()" placeholder="Сумма заказа"></td>
                        <td>
                            <?php if(isset($order['js_del'])): ?>
                            <img src="<?=$order['img_del']?>" title="<?=$order['title_del']?>" 
                                 class="cursor_pointer" onclick="<?=$order['js_del']?>">
                            <?php endif; ?>
                        </td>
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
                Срок поставки <input class="form-control input-sm-min" order_cod="order_delivery_time"> дней
            </div>
            <div class="order_percent_discount">
                Процент скидки <input class="form-control input-sm-min" order_cod="order_percent_discount"
                                <?=(isset($accesses) && in_array(1, $accesses) ? "" : "readonly")?> 
                                value="<?=$order['percent_discount']?>"> %
            </div>
            <div class="order_all_sum">
                Общая сумма <input class="form-control input-sm-min" value="0" order_cod="order_all_sum" readonly>
            </div>
            <div class="clear_float"></div>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$order['js_save']?>">Сохранить изменения</button>
    </div>
    <?php elseif(isset($act) && $act == 'edit'): ?>
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
    <?php elseif(isset($act) && $act == 'add_auto'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$order['title']?></h4>
    </div>
    <?php if(!empty($error)):?>
    <div class="alert alert-danger alert-min">
        <?=$error?>
    </div>
    <?php else:?>
    <div class="modal-body">
        <div class="order_auto_tbody_lists">
            <input type="hidden" id="order_auto_client_id" value="<?=$order['client_id']?>">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Артикул</th>
                        <th>Поставщика</th>
                        <th>Название детали</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th><input type="checkbox" class="check_auto_order" id="checkAll" onclick="checkAll(this)"/></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($order['auto_orders'])):?>
                        <?php if(is_array($order['auto_orders'])):?>
                            <?php foreach ($order['auto_orders'] as $value):?>
                                <?php if(isset($value) && is_object($value) && isset($value->GlobalId)):?>
                                    <tr class="order_auto_lists">
                                        <td class="global_id"><?=$value->GlobalId?></td>
                                        <td class="detail_num"><?=$value->DetailNum?></td>
                                        <td class="make_name"><?=$value->MakeName?></td>
                                        <td class="detail_name_rus_user"><?=$value->DetailNameRusUser?></td>
                                        <td class="detail_quantity"><?=$value->DetailQuantity?></td>
                                        <td class="price_potr_order_rur"><?=ceil($value->PricePotrOrderRUR)?></td>
                                        <td><input type="checkbox" name="check_auto_order" class="check_auto_order"/></td>
                                    </tr>
                                <?php endif;?>
                            <?php endforeach;?> 
                        <?php else:?>
                            <?php if(is_object($order['auto_orders']) && isset($order['auto_orders']->GlobalId)):?>
                                <tr class="order_auto_lists">
                                    <td class="global_id"><?=$order['auto_orders']->GlobalId?></td>
                                    <td class="detail_num"><?=$order['auto_orders']->DetailNum?></td>
                                    <td class="make_name"><?=$order['auto_orders']->MakeName?></td>
                                    <td class="detail_name_rus_user"><?=$order['auto_orders']->DetailNameRusUser?></td>
                                    <td class="detail_quantity"><?=$order['auto_orders']->DetailQuantity?></td>
                                    <td class="price_potr_order_rur"><?=ceil($order['auto_orders']->PricePotrOrderRUR)?></td>
                                    <td><input type="checkbox" name="check_auto_order" class="check_auto_order"/></td>
                                </tr>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$order['js_save']?>">Загрузить оборудование</button>
    </div>
    <?php endif;?>
    <?php endif; ?>
<?php elseif(isset($send_sms)): ?>  
    <?php if(isset($act) && $act == 'send_sms'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$send_sms['title']?></h4>
    </div>
    <div class="modal-body">
        <div class="order_tbody_lists">
            <input type="hidden" id="send_sms_client_id" value="<?=$send_sms['client_id']?>">
            <input type="hidden" id="send_sms_order_id" value="<?=$send_sms['order_id']?>">
            <label for="phone_number">Номер телефона:</label>
            <input class="form-control input-sm-min" id="phone_number" value="<?=$send_sms['phone']?>" 
                   placeholder="Номер телефона">
            <label for="message">Сообщение:</label>
            <textarea class="form-control input-sm-min" id="message" cols="40" rows="6"><?=$send_sms['message']?></textarea>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$send_sms['js_save']?>">Послать СМС</button>
    </div>
    <?php endif; ?>
<?php elseif(isset($order_abcp)): ?>  
    <?php if(isset($act) && $act == 'add_abcp'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$order_abcp['title']?></h4>
    </div>
    <div class="modal-body">
        <div class="order_tbody_lists">
            <input type="hidden" id="order_abcp_client_id" value="<?=$order_abcp['client_id']?>">
            <label for="order_abcp_number">Номер заказа:</label>
            <input class="form-control input-sm-min" id="order_abcp_number" placeholder="Номер заказа">
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$order_abcp['js_save']?>">Загрузить оборудование</button>
    </div>
    <?php endif; ?>
<?php endif; ?>