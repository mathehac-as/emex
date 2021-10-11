<?php if(isset($creditcard)): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?=$creditcard['title']?></h4>
</div>
<div class="modal-body">
    <input type="hidden" id="creditcard_order_id" value="<?=$creditcard['order_id']?>">
    <label for="creditcard_order_number">Номер карты</label>
    <input class="form-control input-sm-min" id="creditcard_order_number" placeholder="Номер карты">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <button type="button" class="btn btn-primary" onclick="<?=$creditcard['js_save']?>">Сохранить изменения</button>
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
