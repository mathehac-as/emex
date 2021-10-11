<?php if(isset($errors)):?>
    <div class="alert alert-danger alert-min"><?=$errors?></div>
<?php elseif(isset($msg)):?>
    <div class="alert alert-success alert-min"><?=$msg?></div>
<?php endif; ?>
<?php if(isset($client) && count($client) > 0): ?>
    <?php if(!isset($act)): ?>
    <table class="table table-condensed">
        <tbody>
            <input type="hidden" id="client_id" value="<?=$client['id']?>">
            <tr client_id="<?=$client['id']?>" class="bg_cont_client_lists_tr">
                <td class="bg_cont_client_lists_fio"><b>ФИО:</b> <?=$client['fio']?></td>
                <td class="bg_cont_client_lists_phone"><img src="/img/phone.png"></img> <?=$client['phone']?></td>
                <td class="bg_cont_client_lists_btn">
                    <?php if(isset($client['img_save'])): ?>
                    <img src="<?=$client['img_save']?>" title="<?=$client['title_save']?>" class="cursor_pointer"
                         onclick="<?=$client['js_save']?>">
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="bg_cont_client_lists_tr">
                <td class="bg_cont_client_lists_vin"><b>VIN:</b> <?=$client['vin']?></td>
                <td class="bg_cont_client_lists_marka"><b>Марка авто:</b> <?=$client['marka_avto']?></td>
            </tr>
            <tr class="bg_cont_client_lists_tr">
                <td class="bg_cont_client_lists_sum_order"><b>Общая сумма заказов:</b> <?=$client['sum_order']?> руб.</td>
                <td class="bg_cont_client_lists_sum_debt" style="color:<?=($client['sum_debt'] >= 0 ? 'green' : 'red' )?>"><b>Общая задолженность:</b> <?=(int)$client['sum_debt']?> руб.</td>
            </tr>
        </tbody>
    </table>
    <?php elseif($act == 'edit'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$client['title']?></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="client_id" value="<?=$client['id']?>">
        <label for="client_fio">ФИО</label>
        <input type="text" class="form-control input-sm-min" id="client_fio" value="<?=$client['fio']?>" placeholder="ФИО">
        <label for="client_emex_id">Emex ID</label>
        <input type="text" class="form-control input-sm-min" id="client_emex_id" value="<?=$client['emex_id']?>" placeholder="Emex ID">
        <label for="client_vin">VIN</label>
        <input class="form-control input-sm-min" id="client_vin" value="<?=$client['vin']?>" placeholder="VIN">
        <label for="client_marka_avto">Марка авто</label>
        <input class="form-control input-sm-min" id="client_marka_avto" value="<?=$client['marka_avto']?>" placeholder="Марка авто">
        <label for="client_organization">Организация</label>
        <input class="form-control input-sm-min" id="client_organization" value="<?=$client['organization']?>" placeholder="Организация">
        <label for="client_phone">Контактный телефон</label>
        <input type="text" class="form-control input-sm-min" id="client_phone" value="<?=$client['phone']?>" placeholder="Контактный телефон">
        <label for="client_email">e-mail</label>
        <input type="text" class="form-control input-sm-min" id="client_email" value="<?=$client['email']?>" placeholder="e-mail">
        <label for="client_percent_discount">Процент скидки</label>
        <input class="form-control input-sm-min" id="client_percent_discount" value="<?=$client['percent_discount']?>" placeholder="Процент скидки">
        <label for="client_comment">Комментарии</label>
        <textarea class="form-control input-sm-min" id="client_comment"><?=$client['comment']?></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$client['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info alert-min">Клиент не выбран</div>
<?php endif; ?>
