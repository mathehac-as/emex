<?php if(isset($client)): ?>
<div id="bg_cont_client_list"><?=$client?></div>
<?php endif; ?>
<?php if(isset($orders)): ?>
<div id="bg_cont_list_orders"><?=$orders?></div>
<?php endif; ?>
<div id="bg_cont_client_block" class="modal fade">
    <div class="modal-dialog">
        <div id="bg_cont_client_add" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_order_block" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="bg_cont_order_add" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_order_auto_block" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="bg_cont_order_add_auto" class="modal-content">
        </div>
    </div>
</div>
<div id="bg_cont_order_abcp_block" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="bg_cont_order_add_abcp" class="modal-content">
        </div>
    </div>
</div>