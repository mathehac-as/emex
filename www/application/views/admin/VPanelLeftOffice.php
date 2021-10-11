<?php if(isset($user_lists)): ?>
<div class="bg_cont_list_head">
    Список менеджеров
    <?php if(isset($user_lists_act)): ?>
    <img src="<?=$user_lists_act['img']?>" onclick="<?=$user_lists_act['js']?>">
    <?php endif; ?>
</div>
<table class="table table-condensed">
    <tbody>
    <?php foreach($user_lists as $val): ?>
        <tr user_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getUser(this);">
            <td><?=$val['fio']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
