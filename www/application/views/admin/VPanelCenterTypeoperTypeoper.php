<?php if(isset($typeoper) && count($typeoper) > 0): ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><?=$typeoper['title']?></h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="typeoper_id" value="<?=$typeoper['id']?>">
        <label for="typeoper_name">Название</label>
        <input type="text" class="form-control input-sm-min" id="typeoper_name" value="<?=$typeoper['name']?>" placeholder="Название">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      <button type="button" class="btn btn-primary" onclick="<?=$typeoper['js_save']?>">Сохранить изменения</button>
    </div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
