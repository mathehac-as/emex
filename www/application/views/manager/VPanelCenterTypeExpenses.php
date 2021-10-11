<?php if(isset($typeexpenses) && count($typeexpenses) > 0): ?>
    <table class="table table-condensed">
        <tbody>
            <tr typeexpenses_id="<?=$typeexpenses['id']?>" class="bg_cont_typeexpenses_lists_tr">
                <td class="bg_cont_typeexpenses_lists_name">Название: </td>
                <td>
                    <input type="text" class="form-control input-sm-min" id="name" 
                           value="<?=$typeexpenses['name']?>" placeholder="Название">
                </td>
                <td class="bg_cont_typeexpenses_lists_btn">
                    <?php if(isset($typeexpenses['img_save'])): ?>
                    <img src="<?=$typeexpenses['img_save']?>" onclick="<?=$typeexpenses['js_save']?>">
                    <?php endif; ?>
                    <?php if(isset($typeexpenses['img_del'])): ?>
                    <img src="<?=$typeexpenses['img_del']?>" onclick="<?=$typeexpenses['js_del']?>">
                    <?php endif; ?>
                   <?php if(isset($typeexpenses['img_cansel'])): ?>
                    <img src="<?=$typeexpenses['img_cansel']?>" onclick="<?=$typeexpenses['js_cansel']?>">
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php elseif(isset($warning)):?>
        <div class="alert alert-warning alert-min"><?=$warning?></div>
    <?php else: ?>
        <div class="alert alert-info alert-min">Тип расходов не выбран</div>
    <?php endif;?>
<?php endif; ?>
<?php if(isset($typeexpenses_act['img'])): ?>
<div class="bg_cont_user_btn_expenses_give">
    <img src="<?=$typeexpenses_act['img']?>" onclick="<?=$typeexpenses_act['js']?>">
</div>
<?php endif; ?>
