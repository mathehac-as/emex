<?php if(isset($errors)):?>
    <div class="alert alert-danger alert-min"><?=$errors?></div>
<?php elseif(isset($msg)):?>
    <div class="alert alert-success alert-min"><?=$msg?></div>
<?php endif;?>
<?php if(isset($user) && count($user) > 0): ?>
    <?php if(!isset($act)): ?>
    <table class="table table-condensed">
        <tbody>
            <tr user_id="<?=$user['id']?>" class="bg_cont_user_lists_tr">
                <td class="bg_cont_user_lists_fio">ФИО: </td>
                <td><?=$user['fio']?></td>
                <td class="bg_cont_user_lists_btn">
                    <?php if(isset($user['img_save'])): ?>
                    <img src="<?=$user['img_save']?>" onclick="<?=$user['js_save']?>">
                    <?php endif; ?>
                    <?php if(isset($user['img_del'])): ?>
                    <img src="<?=$user['img_del']?>" onclick="<?=$user['js_del']?>">
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php elseif($act == 'edit' || $act == 'add'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$user['title']?></h4>
    </div>
    <div class="modal-body">
        <div class="alert alert-warning alert-min">Внимание! Для создания менеджера, воспользуйтесь вкладкой Менеджеры/офисы.</div>
        <input type="hidden" id="user_id" value="<?=$user['id']?>">
        <label for="user_fio">ФИО</label>
        <input class="form-control input-sm-min" id="user_fio" value="<?=$user['fio']?>" placeholder="ФИО">
        <label for="user_position">Должность</label>
        <input class="form-control input-sm-min" id="user_position" value="<?=$user['position']?>" placeholder="Должность">
        <label for="user_phone">№ телефона</label>
        <input class="form-control input-sm-min" id="user_phone" value="<?=$user['phone']?>" placeholder="№ телефона">
        <label for="user_office">Офис</label>
        <select class="form-control input-sm-min" id="user_office" placeholder="Офис">
        <?php if(isset($offices)):?>
            <?php foreach($offices as $offices_val): ?>
                <option value="<?=$offices_val['id']?>" <?=($offices_val['id']== $user['office_id']? ' selected' : '' )?>>
                    <?=$offices_val['name']?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
        </select>
        <label for="user_passport">Паспортные данные</label>
        <input class="form-control input-sm-min" id="user_passport" value="<?=$user['passport']?>" 
               placeholder="Паспортные данные ">
        <label for="user_date_birth">Дата рождения</label>
        <input class="form-control input-sm-min" id="user_date_birth" type="text" value="<?=((int)$user['date_birth'] > 0 ? $user['date_birth'] : '')?>" 
               data-date-format="dd.mm.yyyy" placeholder="dd.mm.yyyy">
        <label for="user_number_card">№ счета банковской карты</label>
        <input class="form-control input-sm-min" id="user_number_card" value="<?=$user['number_card']?>" 
               placeholder="№ счета банковской карты">
        <label for="user_email">e-mail</label>
        <input class="form-control input-sm-min" id="user_email" value="<?=$user['email']?>" placeholder="e-mail">
        <label for="user_comment">Комментарии</label>
        <textarea class="form-control input-sm-min" id="user_comment"><?=$user['comment']?></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$user['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <?php if(isset($warning)):?>
        <div class="alert alert-warning alert-min"><?=$warning?></div>
    <?php else: ?>
        <div class="alert alert-info alert-min">Сотрудник не выбран</div>
    <?php endif;?>
<?php endif; ?>
<?php if(isset($user_act['img'])): ?>
<div class="bg_cont_user_btn_salary_give">
    <img src="<?=$user_act['img']?>" onclick="<?=$user_act['js']?>">
</div>
<?php endif; ?>
