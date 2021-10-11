<?php if(isset($discount)): ?>
<div id="bg_cont_discount_list"><?=$discount?></div>
<?php endif; ?>
<?php if(isset($historys)): ?>
<div id="bg_cont_list_historys"><?=$historys?></div>
<?php endif; ?>
<?php if(isset($changehistorys)): ?>
<div id="bg_cont_list_change_historys"><?=$changehistorys?></div>
<?php endif; ?>
<div id="bg_cont_discount_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_discount_add" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_historys_block" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="bg_cont_historys_add" class="modal-content">
        </div>
    </div>
</div>