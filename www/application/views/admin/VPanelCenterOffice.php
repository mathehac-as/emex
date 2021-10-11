<?php if(isset($user)): ?>
<div id="bg_cont_user_list"><?=$user?></div>
<?php endif; ?>
<?php if(isset($offices)): ?>
<div class="bg_cont_list_offices">
    <div class="bg_cont_list_head">Офисы 
    <?php if(isset($offices_act)): ?>
        <img src="<?=$offices_act['img']?>" onclick="<?=$offices_act['js']?>">
    <?php endif; ?>
    </div>
    <div class="bg_cont_list_btn">
    <?php if(isset($offices['data'])): ?>
        <?php foreach($offices['data'] as $val): ?>
            <div office_id="<?=$val['id']?>">
                <?=(isset($val['group_name']) ? '('.$val['group_name'].') ' : '').$val['name']?>
                <?php if(isset($offices['act']['img_link']) || isset($offices['act']['img_unlink'])): ?>
                    <?php if(!isset($val['group_id']) || (int)$val['group_id'] == 0): ?>
                    <img src="<?=$offices['act']['img_link']?>" onclick="<?=$offices['act']['js_link']?>">
                    <?php else: ?>
                    <img src="<?=$offices['act']['img_unlink']?>" onclick="<?=$offices['act']['js_unlink']?>">
                    <?php endif; ?>
                <?php endif; ?>
                <?php if(isset($offices['act']['img_edit'])): ?>
                <img src="<?=$offices['act']['img_edit']?>" onclick="<?=$offices['act']['js_edit']?>">
                <?php endif; ?>
                <?php if(isset($offices['act']['img_del'])): ?>
                <img src="<?=$offices['act']['img_del']?>" onclick="<?=$offices['act']['js_del']?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <div class="clear_float"></div>
    <table class="table table-condensed">
        <thead>
            <tr><th>Текущий баланс по офисам</th></tr>
        </thead>
        <tbody>
        <?php if(isset($offices['data'])): ?>
            <?php foreach($offices['data'] as $val): ?>
                <tr office_id="<?=$val['id']?>">
                    <td><?=$val['name']?></td>
                    <td><b><?=(isset($val['balance']) ? $val['balance'] : 0 )?></b> руб.</td>
                    <td>
                    <?php if($val['balance']):?>
                        <button type="button" class="btn btn-primary btn-xs" 
                                onclick="getOfficeCash(this, 'outcash')">Инкассация</button>
                    <?php endif; ?>
                    </td>
                    <td><button type="button" class="btn btn-primary btn-xs"
                                onclick="getOfficeCash(this, 'incash')">Внести в кассу</button></td>
                    <td><button type="button" class="btn btn-primary btn-xs"
                                onclick="getOfficeCash(this, 'correction')">Коррекция</button></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
            <tr>
                <td class="offices_total">Всего: </td>
                <td>
                    <b><?=(isset($total[0]['sum']) ? $total[0]['sum'] : 0 )?></b> руб.
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php endif; ?>
<div id="bg_cont_offices_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_offices_add" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_user_emex_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_user_emex_edit" class="modal-content">
        </div>
    </div>
</div>