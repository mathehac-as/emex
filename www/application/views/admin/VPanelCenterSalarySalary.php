<?php if(isset($salarys) && count($salarys) > 0): ?>
    <?php if(!isset($act)): ?>
    <div class="bg_cont_list_salarys">
        <div class="bg_cont_list_head">Зарплата</div>
        <div class="bg_cont_list_salary_base">
            <div class="bg_cont_list_salary_journal"> 
                <table class="table table-condensed">
                    <thead>
                        <tr class="salary_head"><th>Комментарий</th><th>Дата</th><th>Сумма</th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($salarys as $key => $val): ?>
                        <tr>
                            <td class="salary_manth"><?=$key?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach($val as $k => $v): ?>
                        <tr>
                            <td class="salary_manth"><?=$date[$k]?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach($v as $value): ?>
                            <tr>
                                <td><?=$value['comment']?></td>
                                <td><?=date('d.m.Y h:i:s', strtotime($value['salary_date']))?></td>
                                <td><b><?=(isset($value['sum']) ? $value['sum'] : 0 )?></b> руб.</td>
                            </tr>
                        <?php endforeach;?>
                        <tr class="salary_sum">
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
        <h4 class="modal-title"><?=$salarys['title']?></h4>
    </div>
    <div class="modal-body">
        <label for="salary_sum">Сумма</label>
        <input type="text" class="form-control input-sm-min" id="salary_sum" placeholder="Сумма">
        <label for="salary_office_id">Касса офиса</label>
        <select class="form-control input-sm-min" id="salary_office_id">
        <?php if(isset($salarys['offices'])):?>
            <?php foreach($salarys['offices'] as $offices_val): ?>
                <option value="<?=$offices_val['id']?>">
                    <?=$offices_val['name']?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
        </select>
        <label for="salary_comment">Комментарии</label>
        <textarea class="form-control input-sm-min" id="salary_comment"></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$salarys['js_save']?>">Сохранить изменения</button>
    </div>
    <?php endif; ?>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>