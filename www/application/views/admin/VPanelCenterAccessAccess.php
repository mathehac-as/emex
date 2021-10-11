<div id="msg_alert_access">
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
</div>
<?php if(isset($access_lists) && count($access_lists) > 0): ?>
    <div class="bg_cont_list_access">
        <div class="bg_cont_list_access_head">Права доступа</div>
        <div class="bg_cont_list_access_base">
            <table class="table table-condensed">
                <thead>
                    <tr class="access_head"><th>Название</th><th>Опция</th></tr>
                </thead>
                <tbody>
                <?php foreach($access_lists as $key => $val): ?>
                    <tr>
                        <td><?=$val['name']?></td>
                        <td>
                            <input type="checkbox" name="user_check" id="user_check" access_id="<?=$val['id']?>"
                                onclick="setAccessUserCheck(this)" <?=((int)$val['user_check'] == 0 ? '' : 'checked')?>>
                        </td>
                    </tr>
                <?php endforeach; ?> 
                </tbody>
            </table>
        </div>       
    </div>    
<?php endif; ?>