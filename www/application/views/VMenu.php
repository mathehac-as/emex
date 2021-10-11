<div class="bg_menu_cont"> 
    <ul class="nav nav-pills">
    <?php foreach($menus as $val): ?>
        <?php if($user_perm == 'admin' || $val['act'] != 'expenses' || (isset($access) && in_array(13, $access))):?>
            <li<?=($val['active'] ? ' class="active"' : '')?>><a href="<?=$val['act']?>"><?=$val['name']?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
    </ul>
</div>
