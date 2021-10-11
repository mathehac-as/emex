<!DOCTYPE html>
<html lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title_site.' | '.$title_page?></title>
<meta name="description" content="<?=$description?>" />
<?php if(isset($scripts)): ?>
<?php foreach($scripts as $script):?>
<?=HTML::script($script)?>
<?php endforeach; ?>
<?php endif; ?>
<?php if(isset($styles)): ?>
<?php foreach($styles as $style):?>
<?=HTML::style($style)?>
<?php endforeach; ?>
<?php endif; ?>
</head>
<body<?=((isset($script_print))? ' onload="'.$script_print.'"' : '')?>>
    <?php if(isset($print_order)): ?>
    <div class="bg_print_block">
        <?=$print_order?>
    </div>
    <?php endif; ?>
    <div class="clear_float"></div>
</body>
</html>
