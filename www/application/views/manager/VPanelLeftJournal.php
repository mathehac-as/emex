<?php if(isset($order_date_lists)): ?>
<div class="bg_cont_journal_lists_head">
    <div class="bg_cont_list_head_journal">Дата</div>
</div>
<input type="hidden" id="office_id" name="office_id" value="<?=$office_id?>">
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
