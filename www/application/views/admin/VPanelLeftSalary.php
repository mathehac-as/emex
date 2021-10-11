<?php if(isset($users)): ?>
<div class="bg_cont_list_head">
    Список сотрудников
    <?php if(isset($user_lists_act)): ?>
    <img src="<?=$user_lists_act['img']?>" onclick="<?=$user_lists_act['js']?>">
    <?php endif; ?>
</div>
<div class="bg_cont_user_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($users as $val): ?>
            <tr user_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getUserSalary(this);">
                <td><?=$val['fio']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
