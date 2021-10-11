<?php if(isset($client_lists)): ?>
<div class="bg_cont_client_lists_head">
    <div class="bg_cont_list_head_client">
        Список клиентов
        <?php if(isset($client_lists_act['add'])): ?>
        <img src="<?=$client_lists_act['add']['img']?>" title="<?=$client_lists_act['add']['title']?>"
             class="cursor_pointer" onclick="<?=$client_lists_act['add']['js']?>">
        <?php endif; ?>
        <?php if(isset($client_lists_act['refresh'])): ?>
        <img src="<?=$client_lists_act['refresh']['img']?>" title="<?=$client_lists_act['refresh']['title']?>"
             class="cursor_pointer" onclick="<?=$client_lists_act['refresh']['js']?>">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control input-sm-min" id="search_order_abcp" placeholder="Поиск по номеру ABCP" autocomplete="off">
            <span class="input-group-btn">
                <button id="btn-search-abcp" class="btn btn-default input-sm-min" onclick="getOrderSearchABCP()" type="button">Найти</button>
            </span>
        </div>
        <div class="input-group">
            <input type="text" class="form-control input-sm-min" id="search_order" placeholder="Поиск по номеру заказа" autocomplete="off">
            <span class="input-group-btn">
                <button id="btn-search" class="btn btn-default input-sm-min" onclick="getOrderSearch()" type="button">Найти</button>
            </span>
        </div>
        <input type="text" class="form-control input-sm-min" id="search_client" 
               oninput="getClientSearch(this);" onkeypress="getClientSearch(this);" placeholder="Поиск данным клиента" autocomplete="off">
        <input type="hidden" id="office_id" name="office_id" value="<?=$office_id?>">
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
