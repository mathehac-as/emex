<?php if(isset($client_lists)): ?>
<div class="bg_cont_history_lists_head">
    <div class="bg_cont_list_head_history">
        Список клиентов
        <?php if(isset($client_lists_act['send'])): ?>
        <img src="<?=$client_lists_act['send']['img']?>" title="<?=$client_lists_act['send']['title']?>"
             class="cursor_pointer" onclick="<?=$client_lists_act['send']['js']?>">
        <?php endif; ?>
        <?php if(isset($client_lists_act['delivery'])): ?>
        <img src="<?=$client_lists_act['delivery']['img']?>" title="<?=$client_lists_act['delivery']['title']?>"
             class="cursor_pointer" onclick="<?=$client_lists_act['delivery']['js']?>">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <input type="text" class="form-control input-sm-min" id="search_client_history" 
               oninput="getClientHistorySearch(this);" placeholder="Поиск" autocomplete="off">
    </div>
</div>
<div class="bg_cont_history_lists">
    <table class="table table-condensed">
        <tbody>
            <tr client_id="0" class="bg_cont_list_tr" onclick="getHistory(this);">
                <td>Без заказа</td>
            </tr>
        <?php foreach($client_lists as $key => $val): ?>
            <tr client_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getHistory(this);">
                <td><?=($key+1) . ': ' . $val['fio']?> - <?=$val['phone']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>