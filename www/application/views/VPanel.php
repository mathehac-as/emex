<div class="bg_cont"> 
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title panel_name"><?=$panel_name?></div>
            <div class="panel_outlog">
                <button type="button" class="btn btn-primary btn-xs" 
                        onclick="location.href='index/logout';">Выход</button>
            </div> 
            <div class="panel_user"><?=$user_type?> : <?=$user_name?></div>  
            <div class="clear_float"></div>
        </div>
        <div class="panel-body">
        <?php if(isset($menus)): ?>
            <div class="bg_menu"><?=$menus?></div>
        <?php endif; ?>
        <?php if(isset($lists)): ?>
            <div class="bg_cont_list"><?=$lists?></div>
        <?php endif; ?>
        <?php if(isset($panels)): ?>
            <div class="bg_cont_panel"><?=$panels?></div>
        <?php endif; ?>
        </div>
    </div>
</div>
<div id="load_block">
    <img id="load_img" src="/img/load.gif" />
</div>