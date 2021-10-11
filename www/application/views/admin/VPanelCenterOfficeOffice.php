<?php if(isset($office)): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?=$office['title']?></h4>
</div>
<div class="modal-body">
    <input type="hidden" id="office_id" value="<?=$office['id']?>">
    <label for="name">Название</label>
    <input type="text" class="form-control input-sm-min" id="name" value="<?=$office['name']?>" placeholder="Название">
    <label for="phone">Телефон</label>
    <input type="text" class="form-control input-sm-min" id="phone" value="<?=$office['phone']?>" placeholder="Телефон">
    <label for="comment">Комментарии</label>
    <textarea class="form-control input-sm-min" id="comment"><?=$office['comment']?></textarea>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
  <button type="button" class="btn btn-primary" onclick="<?=$office['js_save']?>">Сохранить изменения</button>
</div>
<?php elseif(isset($office_link)): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><?=$office_link['title']?></h4>
</div>
<div class="modal-body">
    <input type="hidden" id="office_link_id" value="<?=$office_link['id']?>">
    <label for="office_link_group_id">Группа</label>
    <select class="form-control input-sm-min" id="office_link_group_id">
        <?php if(isset($office_link['office_groups'])):?>
            <?php foreach($office_link['office_groups'] as $office_link_val): ?>
                <option value="<?=$office_link_val['id']?>">
                    <?=$office_link_val['name']?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
  <button type="button" class="btn btn-primary" onclick="<?=$office_link['js_save']?>">Сохранить изменения</button>
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
