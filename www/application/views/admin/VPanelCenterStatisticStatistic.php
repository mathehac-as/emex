<?php if(isset($statistic) && count($statistic) > 0): ?>
    <div class="bg_cont_list_statistic">
        <div class="bg_cont_list_statistic_head"><?=$statistic['title']?></div>
        <input type="hidden" id="statistic_str_code" value="<?=$statistic['str_code']?>">
        <?php if(isset($statistic['sum']) && count($statistic['sum']) > 0):?>
        <div class="bg_cont_list_statistic_base">
            <table class="table table-condensed">
                <thead>
                    <tr class="statistic_head">
                        <?php foreach ($statistic['sum']['fields'] as $value):?>
                            <th><?=$value?></th>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach ($statistic['sum']['values'] as $value):?>
                            <td><?=$value?></td>
                        <?php endforeach;?>
                        <td>
                        <?php if(isset($statistic['img_export'])): ?>
                            <img src="<?=$statistic['img_export']?>" title="<?=$statistic['title_export']?>"
                                 class="cursor_pointer" onclick="<?=$statistic['js_export']?>">
                        <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
        <?php endif; ?>
        <div class="bg_cont_list_statistic_base">
            <table class="table table-condensed">
                <thead>
                    <tr class="statistic_head">
                        <?php if(isset($statistic['info_act']) && count($statistic['info_act']) > 0):?>
                            <th></th>
                        <?php endif; ?>
                        <?php foreach ($statistic['info']['fields'] as $value):?>
                            <th><?=$value?></th>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($statistic['info']['values'] as $value): ?>
                        <tr>
                            <?php if(isset($statistic['info_act']) && count($statistic['info_act']) > 0):?>
                            <td>
                                <img src="<?=$statistic['info_act']['src']?>" title="<?=$statistic['info_act']['title']?>" class="cursor_pointer"
                                     item_id="<?=$value['id']?>" status="plus" onclick="<?=$statistic['info_act']['onclick']?>">
                            </td>
                            <?php endif; ?>
                            <?php foreach ($value as $val):?>
                                <td><?=$val?></td>
                            <?php endforeach;?>
                            <td>
                                <?php if(isset($statistic['img_save'])): ?>
                                <img src="<?=$statistic['img_save']?>" title="<?=$statistic['title_save']?>"
                                     class="cursor_pointer" onclick="<?=$statistic['js_save']?>">
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>       
    </div>
<?php elseif(isset($order_list) && count($order_list) > 0): ?>
    <div class="bg_cont_list_statistic_order_list">
        <table class="table table-condensed">
            <thead>
                <tr class="statistic_head">
                    <?php foreach ($order_list['info']['fields'] as $value):?>
                        <th><?=$value?></th>
                    <?php endforeach;?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_list['info']['values'] as $value):?>
                <tr>
                    <?php foreach ($value as $val):?>
                        <td><?=$val?></td>
                    <?php endforeach;?>
                    <td>
                        <?php if(isset($order_list['img_save'])): ?>
                        <img src="<?=$order_list['img_save']?>" title="<?=$order_list['title_save']?>"
                             class="cursor_pointer" onclick="<?=$order_list['js_save']?>">
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>
