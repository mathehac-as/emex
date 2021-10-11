<div id="msg_alert_settings">
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
</div>
<?php if(isset($setting) && count($setting) > 0): ?>
    <?php if(!isset($act)): ?>
    <div class="bg_cont_list_settings">
        <div class="bg_cont_list_settings_head">Права доступа</div>
        <div class="bg_cont_list_settings_base">
            <table class="table table-condensed">
                <thead>
                    <tr class="settings_head"><th>Название</th><th>Процент</th><th>Сумма</th><th>Опция</th></tr>
                </thead>
                <tbody>
                    <tr setting_id="<?=$setting['id']?>">
                        <td><?=$setting['comment']?></td>
                        <td><?=$setting['percent']?></td>
                        <td><?=$setting['sum']?></td>
                        <td>
                            <?php if(isset($setting['img_save'])): ?>
                            <img src="<?=$setting['img_save']?>" title="<?=$setting['title_save']?>" setting_id="<?=$setting['id']?>"
                                 class="cursor_pointer" onclick="<?=$setting['js_save']?>">
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>       
    </div>
    <?php elseif($act == 'edit'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$setting['title']?></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="setting_id" value="<?=$setting['id']?>">
        <label for="setting_comment">Название</label>
        <input class="form-control input-sm-min" id="setting_comment" value="<?=$setting['comment']?>" placeholder="Комментарии">
        <label for="setting_percent">Процент</label>
        <input class="form-control input-sm-min" id="setting_percent" value="<?=$setting['percent']?>" placeholder="Процент">
        <label for="setting_sum">Сумма</label>
        <input class="form-control input-sm-min" id="setting_sum" value="<?=$setting['sum']?>" placeholder="Сумма">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$setting['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <div class="alert alert-info alert-min">Настройка не выбрана</div>
<?php endif; ?>