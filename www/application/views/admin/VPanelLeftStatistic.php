<div class="bg_cont_statistic_lists_head">
    <div class="bg_cont_list_head_statistic">Список отчетов</div>
    <div class="bg_cont_statistic_lists_head_btn">
    <?php if(isset($statistic_lists_act)): ?>
        <img src="<?=$statistic_lists_act['img_add']?>" onclick="<?=$statistic_lists_act['js_add']?>">
        <img src="<?=$statistic_lists_act['img_edit']?>" onclick="<?=$statistic_lists_act['js_edit']?>">
        <img src="<?=$statistic_lists_act['img_del']?>" onclick="<?=$statistic_lists_act['js_del']?>">
    <?php endif; ?>
    </div>
</div>
<div class="bg_cont_statistic_lists">
    <table class="table table-condensed">
        <tbody>
        <?php if(isset($statistics) && count($statistics) > 0): ?>
            <?php foreach($statistics as $key => $val): ?>
                <tr statistic_id="<?=$val['id']?>" class="bg_cont_list_tr" onclick="getStatistic(this);">
                    <td><?=($key+1).'. '.$val['name']?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?> 
            <tr class="bg_cont_list_tr">
                <td>Нет отчетов</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>