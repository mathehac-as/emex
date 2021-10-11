<?php if(isset($expensess) && count($expensess) > 0): ?>
    <?php if(!isset($act)): ?>
    <div class="bg_cont_list_expenses">
        <div class="bg_cont_list_head">Зарплата</div>
        <div class="bg_cont_list_expenses_base">
            <div class="bg_cont_list_expenses_journal"> 
                <table class="table table-condensed">
                    <thead>
                        <tr class="expenses_head"><th>Комментарий</th><th>Дата</th><th>Сумма</th><th>Менеджер</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($expensess as $key => $val): ?>
                        <tr>
                            <td class="expenses_manth"><?=$key?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach($val as $k => $v): ?>
                        <tr>
                            <td class="expenses_manth"><?=$date[$k]?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach($v as $value): ?>
                            <tr>
                                <td><?=$value['comment']?></td>
                                <td><?=date('d.m.Y h:i:s', strtotime($value['expenses_date']))?></td>
                                <td><b><?=(isset($value['sum']) ? $value['sum'] : 0 )?></b> руб.</td>
                                <td><?=(isset($value['fio']) ? $value['fio'] : '' )?></td>
                            </tr>
                        <?php endforeach;?>
                        <tr class="expenses_sum">
                            <td></td>
                            <td></td>
                            <td><b><?=(isset($sums[$key][$k]) ? $sums[$key][$k] : 0 )?></b> руб.</td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        </div>       
    </div>
    <?php elseif($act == 'add'): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$expensess['title']?></h4>
    </div>
    <div class="modal-body">
        <label for="expenses_sum">Сумма</label>
        <input type="text" class="form-control input-sm-min" id="expenses_sum" placeholder="Сумма">
        <label for="expenses_office_id">Касса офиса</label>
        <select class="form-control input-sm-min" id="expenses_office_id">
        <?php if(isset($expensess['offices'])):?>
            <?php foreach($expensess['offices'] as $offices_val): ?>
                <option value="<?=$offices_val['id']?>">
                    <?=$offices_val['name']?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
        </select>
        <label for="expenses_comment">Комментарии</label>
        <textarea class="form-control input-sm-min" id="expenses_comment"></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$expensess['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>