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
<body class="main">
    <div class="bg">
        <?php if(isset($left_blocks)): ?>
        <div class="bg_sidebar_left">
            <?php foreach ($left_blocks as $left_block): ?>
                <?=$left_block?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if(isset($center_blocks)): ?>
        <div class="bg_cont_all">
            <?php foreach ($center_blocks as $center_block): ?>
                <?=$center_block?>
            <?php endforeach; ?>            
        </div>
        <?php endif; ?>
        <?php if(isset($right_blocks)): ?>
        <div class="bg_sidebar_right">
            <?php foreach ($right_blocks as $right_block): ?>
                <?=$right_block?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="clear_float"></div>
    </div>
</body>
</html>