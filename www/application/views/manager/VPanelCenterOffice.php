<?php if(isset($offices)): ?>
<div class="bg_cont_list_offices">
    <table class="table table-condensed">
        <thead>
            <tr><th>Текущий баланс по офису</th></tr>
        </thead>
        <tbody>
        <?php if(isset($offices[0])): ?>
            <tr office_id="<?=$offices[0]['id']?>">
                <td><b><?=(isset($offices[0]['balance']) ? $offices[0]['balance'] : 0 )?></b> руб.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>