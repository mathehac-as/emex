<?php if(isset($settings_lists)):?>
<div class="bg_cont_list_head">Список настроек</div>
<div class="bg_cont_user_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($settings_lists as $val): ?>
            <tr settings_id="<?=$val['dc_id']?>" class="bg_cont_list_tr" onclick="getSetting(this);">
                <td><?=$val['dc_comment']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
