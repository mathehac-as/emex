<?php if(isset($offices)): ?>
<div class="bg_cont_client_lists_head">
    <div class="bg_cont_list_head_client">Офисы</div>
    <select class="form-control input-sm-min" id="office_id" onchange="getClientList(0);" autocomplete="off">
    <?php foreach($offices as $offices_val): ?>
        <option value="<?=$offices_val['id']?>"<?=(isset($office_id) && $offices_val['id']== $office_id ? ' selected="selected"' : '' )?>>
            <?=$offices_val['name']?>
        </option>
    <?php endforeach; ?>
    </select>
</div>
<?php endif; ?>
<?php if(isset($client_lists)): ?>
<div class="bg_cont_client_lists_head">
    <div class="bg_cont_list_head_client">Список клиентов</div>
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control input-sm-min" id="search_order" placeholder="Поиск по номеру заказа" autocomplete="off">
            <span class="input-group-btn">
                <button id="btn-search" class="btn btn-default input-sm-min" onclick="getOrderSearch()" type="button">Найти</button>
            </span>
        </div>
        <input type="text" class="form-control input-sm-min" id="search_client" 
               oninput="getClientSearch(this);" onkeypress="getClientSearch(this);" placeholder="Поиск данным клиента" autocomplete="off">
    </div>
</div>
<div class="bg_cont_client_lists">
    <table class="table table-condensed">
        <tbody>
        <?php 
        $count = 1;
        foreach($client_lists as $val): 
        ?>
            <tr client_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getClient(this);">
                <td style="color:<?=($val['sum_debt'] >= 0 ? 'black' : 'red' )?>"><?=$count.'. '.$val['fio']?></td>
            </tr>
        <?php 
        $count++;
        endforeach; 
        ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
