<?php if(isset($typeexpensess)): ?>
<div class="bg_cont_list_head">
    Типы расходов
    <?php if(isset($typeexpenses_lists_act)): ?>
    <img src="<?=$typeexpenses_lists_act['img']?>" onclick="<?=$typeexpenses_lists_act['js']?>">
    <?php endif; ?>
</div>
<div class="bg_cont_typeexpenses_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($typeexpensess as $val): ?>
            <tr typeexpenses_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getTypeExpenses(this);">
                <td><?=$val['name']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
