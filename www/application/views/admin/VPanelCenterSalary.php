<?php if(isset($user)): ?>
<div id="bg_cont_user_list"><?=$user?></div>
<?php endif; ?>
<?php if(isset($salarys)): ?>
<div id="bg_cont_list_salarys"><?=$salarys?></div>
<?php endif; ?>
<div id="bg_cont_salary_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_salary_add" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_salary_user_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_salary_user_add" class="modal-content">
        </div>
    </div>
</div>
