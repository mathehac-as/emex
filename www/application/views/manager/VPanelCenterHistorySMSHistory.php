<?php if(isset($errors)):?>
    <div class="alert alert-danger alert-min"><?=$errors?></div>
<?php elseif(isset($msg)):?>
    <div class="alert alert-success alert-min"><?=$msg?></div>
<?php endif;?>
<?php if(isset($historys) && count($historys) > 0): ?>
<div class="bg_cont_list_historysms">
    <div class="bg_cont_list_head">
        История
        <?php if(isset($historys_act['clear'])): ?>
        <img src="<?=$historys_act['clear']['img']?>" title="<?=$historys_act['clear']['title']?>" 
            class="cursor_pointer" onclick="<?=$historys_act['clear']['js']?>">
        <?php endif; ?>
    </div>
    <div class="bg_cont_list_historysms_base">
        <div class="bg_cont_list_historysms_journal"> 
            <table class="table table-condensed">
                <thead>
                    <tr class="historysms_head">
                        <th>Описание</th>
                        <th>Дата</th>
                        <th>ФИО менеджера</th>
                        <th>Номер заказа</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($historys as $key => $val): ?>
                    <tr>
                        <td><?=$val['base']?></td>
                        <td><?=date('d.m.Y h:i:s', strtotime($val['date_history']))?></td>
                        <td><?=(isset($val['fio']) ? $val['fio'] : '' )?></td>
                        <td><?=(isset($val['order_id']) ? $val['order_id'] : '' )?></td>
                        <td><?=$val['comment']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>       
</div>
<?php elseif(isset($send_sms_one)): ?>  
    <?php if(isset($act) && $act == 'send_sms_one'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$send_sms_one['title']?></h4>
    </div>
    <div class="modal-body">
        <div class="order_tbody_lists">
            <label for="phone_number">Номер телефона:</label>
            <input class="form-control input-sm-min" id="phone_number" value="" placeholder="Номер телефона">
            <label for="message">Сообщение:</label>
            <textarea class="form-control input-sm-min" id="message" cols="40" rows="6"></textarea>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$send_sms_one['js_save']?>">Послать СМС</button>
    </div>
    <?php endif; ?>
<?php elseif(isset($delivery_sms)): ?>  
    <?php if(isset($act) && $act == 'delivery_sms'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$delivery_sms['title']?></h4>
    </div>
    <div class="modal-body">
        <div>
            <div class="client_tbody_lists">
                <div class="form-group">
                    <input type="text" class="form-control input-sm-min" id="search_client_delivery_sms" 
                           oninput="getClientDeliverySmsSearch(this);" placeholder="Поиск" autocomplete="off">
                </div>
                <table class="table table-condensed" id="history_client_table_check">
                    <tbody>
                    <?php foreach($client_lists as $key => $val): ?>
                        <tr class="bg_cont_list_tr">
                            <td>
                                <input type="checkbox" class="history_client_tbody_check" value="ON" phone_number="<?=$val['phone']?>"> 
                                <?=($key+1) . ': ' . $val['fio']?> - <?=$val['phone']?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="history_tbody_lists">
                <label for="delivery_sms_message">Сообщение:</label>
                <textarea class="form-control input-sm-min" id="delivery_sms_message" cols="40" rows="9"></textarea>
                <label for="comment_sms_message">Комментарии:</label>
                <textarea class="form-control input-sm-min" id="comment_sms_message" cols="40" rows="9"></textarea>
            </div>
        </div>
        <div class="clear_float"></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$delivery_sms['js_save']?>">Послать СМС</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info alert-min">Клиент не выбран</div>
<?php endif; ?>

