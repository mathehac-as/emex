<?php if(isset($errors)):?>
    <div class="alert alert-danger alert-min"><?=$errors?></div>
<?php elseif(isset($msg)):?>
    <div class="alert alert-success alert-min"><?=$msg?></div>
<?php endif;?>
<?php if(isset($discount) && count($discount) > 0): ?>
    <?php if(!isset($act)): ?>
    <table class="table table-condensed">
        <tbody>
            <input type="hidden" id="discount_id" value="<?=$discount['id']?>">
            <tr discount_id="<?=$discount['id']?>" class="bg_cont_discount_lists_tr">
                <td class="bg_cont_discount_lists_number"><b>Номер катры:</b> <?=$discount['number']?> - <?=$discount['percent']."%"?></td>
                <td class="bg_cont_discount_lists_number_code"><b>Идентификатор:</b> <?=$discount['number_code']?> - <?=$discount['bonus']." б."?></td>
                <td class="bg_cont_discount_lists_fio"><b>ФИО:</b> <?=$discount['fio']?></td>
                <td class="bg_cont_discount_lists_btn">
                    <?php if(isset($discount['img_save']) && isset($accesses) && in_array(3, $accesses)): ?>
                    <img src="<?=$discount['img_save']?>" title="<?=$discount['title_save']?>" class="cursor_pointer"
                         onclick="<?=$discount['js_save']?>">
                    <?php endif; ?>
                </td>
            </tr>
            <tr class="bg_cont_discount_lists_tr">
                <td class="bg_cont_discount_lists_birthday"><b>Дата рождения:</b> <?=$discount['birthday']?></td>
                <td class="bg_cont_discount_lists_phone"><b>Телефон:</b> <?=$discount['phone']?></td>
                <td class="bg_cont_discount_lists_address"><b>Адрес:</b> <?=$discount['address']?></td>
            </tr>
        </tbody>
    </table>
    <?php elseif($act == 'edit' || $act == 'add'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$discount['title']?></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="discount_id" value="<?=$discount['id']?>">
        <label for="discount_number">Номер катры:</label>
        <input class="form-control input-sm-min" id="discount_number" value="<?=$discount['number']?>" 
               placeholder="Номер катры">
        <label for="discount_number_code">Идентификатор:</label>
        <input class="form-control input-sm-min" id="discount_number_code" value="<?=$discount['number_code']?>" 
               placeholder="Идентификатор">
        <label for="discount_fio">ФИО</label>
        <input class="form-control input-sm-min" id="discount_fio" value="<?=$discount['fio']?>" placeholder="ФИО">
        <label for="discount_birthday">Дата рождения</label>
        <input class="form-control input-sm-min" id="discount_birthday" readonly type="text" 
               value="<?=((int)$discount['birthday'] > 0 ? $discount['birthday'] : '')?>" data-date-format="dd.mm.yyyy" placeholder="dd.mm.yyyy">
        <label for="discount_phone">Телефон</label>
        <input class="form-control input-sm-min" id="discount_phone" value="<?=$discount['phone']?>" 
               placeholder="Телефон">
        <label for="discount_address">Адрес</label>
        <input class="form-control input-sm-min" id="discount_address" value="<?=$discount['address']?>" 
               placeholder="Адрес">
        <label for="discount_percent" id="discount_percent_label">Процент</label>
        <input class="form-control input-sm-min" id="discount_percent" value="<?=$discount['percent']?>" 
               placeholder="Процент">
        <input type="checkbox" id="discount_percent_fixed" <?=($discount['percent_fixed'] == 1 ? "checked" : "")?>>  Фиксированный
        <label for="discount_bonus" id="discount_bonus_label">Бонус</label>
        <input class="form-control input-sm-min" id="discount_bonus"<?=(!in_array(11, $accesses) ? ' readonly' : '')?> value="<?=$discount['bonus']?>" 
               placeholder="Бонус">
        <input type="hidden" class="form-control input-sm-min" id="discount_bonus_before" value="<?=$discount['bonus']?>">
        <input type="checkbox" id="discount_bonus_no_writeoff" <?=($discount['bonus_no_writeoff'] == 1 ? "checked" : "")?>>  Не списывать
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$discount['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info alert-min">Карта не выбрана</div>
<?php endif; ?>
