<?php if(isset($user)): ?>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>ФИО</th><th>Логин</th><th>Пароль</th><th>Активен</th><th>Офис</th><th>Опции</th>
            </tr>
        </thead>
        <tbody>
            <tr user_id="<?=$user['id']?>">
                <td><input type="text" class="form-control input-sm-min" id="fio" value="<?=$user['fio']?>" placeholder="ФИО"></td>
                <td><input type="text" class="form-control input-sm-min" id="username" value="<?=$user['login']?>" placeholder="Логин"></td>
                <td><input type="text" class="form-control input-sm-min" id="password" placeholder="Пароль"></td>
                <td><input type="checkbox" class="form-control input-sm-min"<?=($user['is_active'] ? ' checked' : '')?> id="is_active"></td>
                <td>
                    <select class="form-control input-sm-min" id="office_id" placeholder="Офис">
                        <option value=""></option>
                    <?php foreach($offices as $offices_val): ?>
                        <option value="<?=$offices_val['id']?>"<?=($offices_val['id']== $user['office_id']? ' selected' : '' )?>>
                            <?=$offices_val['name']?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td style="width: 80px">
                    <?php if(isset($user['img_save'])): ?>
                    <img src="<?=$user['img_save']?>" onclick="<?=$user['js_save']?>">
                    <?php endif; ?>
                    <?php if(isset($user['img_del'])): ?>
                    <img src="<?=$user['img_del']?>" onclick="<?=$user['js_del']?>">
                    <?php endif; ?>
                    <?php if(isset($user['img_cansel'])): ?>
                    <img src="<?=$user['img_cansel']?>" onclick="<?=$user['js_cansel']?>">
                    <?php endif; ?>
                    <?php if(isset($user['img_emex'])): ?>
                    <img src="<?=$user['img_emex']?>" onclick="<?=$user['js_emex']?>">
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php elseif(isset($user_emex)): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$user_emex['title']?></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="user_id" value="<?=$user_emex['id']?>">
        <label for="emex_id">Логин</label>
        <input type="text" class="form-control input-sm-min" id="emex_id" value="<?=$user_emex['emex_id']?>" placeholder="Логин">
        <label for="emex_pass">Пароль</label>
        <input type="text" class="form-control input-sm-min" id="emex_pass" value="<?=$user_emex['emex_pass']?>" placeholder="Пароль">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$user_emex['js_save']?>">Сохранить изменения</button>
    </div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php else: ?>
        <div class="alert alert-info alert-min">Менеджер не выбран</div>
    <?php endif;?>
<?php endif; ?>