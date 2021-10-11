<?php if(isset($cash)): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?=$cash['title']?></h4>
</div>
<div class="modal-body">
    <input type="hidden" id="cash_office_id" value="<?=$cash['office_id']?>">
    <input type="hidden" id="cash_office_type" value="<?=$cash['type']?>">
    <label for="cash_office_sum">Сумма</label>
    <input type="text" class="form-control input-sm-min" id="cash_office_sum" placeholder="Сумма">
    <label for="cash_office_comment">Комментарии</label>
    <textarea class="form-control input-sm-min" id="cash_office_comment"></textarea>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
  <button type="button" class="btn btn-primary" onclick="<?=$cash['js_save']?>">Сохранить изменения</button>
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
