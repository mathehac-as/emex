<?php if(isset($user_lists)): ?>
<div class="bg_cont_list_head">Список сотрудников</div>
<div class="bg_cont_user_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($user_lists as $val): ?>
            <tr user_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getUserAccess(this);">
                <td><?=$val['fio']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
