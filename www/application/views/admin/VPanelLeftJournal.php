<?php if(isset($offices)): ?>
<div class="bg_cont_journal_lists_head">
    <div class="bg_cont_list_head_journal">Офисы</div>
    <select class="form-control input-sm-min" id="office_id" onchange="getJournalList(this);" autocomplete="off">
    <?php foreach($offices as $offices_val): ?>
        <option value="<?=$offices_val['id']?>"<?=(isset($office_id) && $offices_val['id']== $office_id ? ' selected="selected"' : '' )?>>
            <?=$offices_val['name']?>
        </option>
    <?php endforeach; ?>
    </select>
</div>
<?php endif; ?>
<?php if(isset($order_date_lists)): ?>
<div class="bg_cont_journal_lists_head">
    <div class="bg_cont_list_head_journal">Дата</div>
</div>
<div class="bg_cont_journal_lists">
    <table class="table table-condensed">
        <tbody>
        <?php foreach($order_date_lists as $val): ?>
            <tr class="bg_cont_list_tr" onclick="getJournals(this);" date_sel="<?=$val['date_sel']?>">
                <td><?=date('d.m.Y', strtotime($val['date_sel']))?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
