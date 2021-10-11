<div class="bg_cont_typeoper_lists_head">
    <div class="bg_cont_list_head_typeoper">Список операций</div>
    <div class="bg_cont_typeoper_lists_head_btn">
    <?php if(isset($typeoper_lists_act)): ?>
        <img src="<?=$typeoper_lists_act['img_add']?>" onclick="<?=$typeoper_lists_act['js_add']?>">
        <img src="<?=$typeoper_lists_act['img_edit']?>" onclick="<?=$typeoper_lists_act['js_edit']?>">
        <img src="<?=$typeoper_lists_act['img_del']?>" onclick="<?=$typeoper_lists_act['js_del']?>">
    <?php endif; ?>
    </div>
</div>
<div class="bg_cont_typeoper_lists">
    <table class="table table-condensed">
        <tbody>
        <?php if(isset($typeopers) && count($typeopers) > 0): ?>
            <?php foreach($typeopers as $val): ?>
                <tr typeoper_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="setTypeoper(this);">
                    <td><?=$val['name']?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?> 
            <tr class="bg_cont_list_tr">
                <td>Нет опреаций</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>