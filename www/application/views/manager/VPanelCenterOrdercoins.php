<?php if(isset($coins)): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?=$coins['title']?></h4>
</div>
<div class="modal-body">
    <input type="hidden" id="coins_office_id" value="<?=$coins['office_id']?>">
    <label for="coins_order_sum">Сумма</label>
    <input class="form-control input-sm-min" id="coins_order_sum" placeholder="Сумма">
    <input type="checkbox" id="coins_order_cashless">  Безналичный
    <label for="coins_order_comment" id="coins_order_comment_label">Комментарии</label>
    <textarea class="form-control input-sm-min" id="coins_order_comment"></textarea>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="button" class="btn btn-primary" onclick="<?=$coins['js_save']?>">Сохранить изменения</button>
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
