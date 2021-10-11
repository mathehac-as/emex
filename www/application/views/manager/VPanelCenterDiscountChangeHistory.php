<?php if(isset($discountchangehistorys) && count($discountchangehistorys) > 0): ?>
<div class="bg_cont_list_discounthistorys">
    <div class="bg_cont_list_head">История по балам</div>
    <div class="bg_cont_list_discounthistorys_base">
        <div class="bg_cont_list_discounthistorys_journal"> 
            <table class="table table-condensed">
                <thead>
                    <tr class="discounthistorys_head">
                        <th>Комментарий</th>
                        <th>Дата</th>
                        <th>Бал до</th>
                        <th>Бал после</th>
                        <th>Пользователь</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($discountchangehistorys as $key => $val): ?>
                    <tr>
                        <td><?=$val['dl_comment']?></td>
                        <td><?=date('d.m.Y h:i:s', strtotime($val['dl_date_create']))?></td>
                        <td><?=$val['dl_before']?></td>
                        <td><?=$val['dl_after']?></td>
                        <td><?=$val['dl_user_name']?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>       
</div>
<?php else: ?>
    <?php if(isset($errors)):?>
        <div class="alert alert-danger alert-min"><?=$errors?></div>
    <?php elseif(isset($msg)):?>
        <div class="alert alert-success alert-min"><?=$msg?></div>
    <?php endif;?>
<?php endif; ?>