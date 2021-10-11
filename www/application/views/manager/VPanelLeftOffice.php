<?php if(isset($offices)): ?>
<div class="bg_cont_list_head">Офис</div>
<table class="table table-condensed">
    <tbody>
    <?php if($offices[0]): ?>
        <tr office_id="<?=$offices[0]['id']?>" class="bg_cont_list_tr" >
            <td><?=$offices[0]['name']?></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?php endif; ?>
