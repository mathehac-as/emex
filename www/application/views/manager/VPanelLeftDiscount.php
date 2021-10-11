<?php if(isset($discount_lists)): ?>
<div class="bg_cont_discount_lists_head">
    <div class="bg_cont_list_head_discount">
        Список карт
        <?php if(isset($discount_lists_act['add'])): ?>
        <img src="<?=$discount_lists_act['add']['img']?>" title="<?=$discount_lists_act['add']['title']?>"
             class="cursor_pointer" onclick="<?=$discount_lists_act['add']['js']?>">
        <?php endif; ?>
        <?php if(isset($discount_lists_act['refresh'])): ?>
        <img src="<?=$discount_lists_act['refresh']['img']?>" title="<?=$discount_lists_act['refresh']['title']?>"
             class="cursor_pointer" onclick="<?=$discount_lists_act['refresh']['js']?>">
        <?php endif; ?>
    </div>
    <div class="form-group">
        <input type="text" class="form-control input-sm-min" id="search_discount" 
               oninput="getDiscountSearch(this);" placeholder="Поиск" autocomplete="off">
    </div>
</div>
<div class="bg_cont_discount_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($discount_lists as $val): ?>
            <tr discount_id="<?=$val['d_id']?>" class="bg_cont_list_tr" onclick="getDiscount(this);">
                <td><?=$val['d_number']?> - <?=$val['d_fio']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
