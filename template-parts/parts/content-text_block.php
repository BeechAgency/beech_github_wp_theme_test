<?php 
    $title = get_acf_value('_title'); 
    $anchor = get_acf_value('_anchor');
    $cols = get_acf_value('_cols');
    $text_1 =  get_acf_value('_text_1');
    $text_2 =  get_acf_value('_text_2');
    $text_3 =  get_acf_value('_text_3');
?>
<div class="content <?= get_row_layout(); ?>" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>

    <div class="row-nowrap cols-<?= $cols ?>">
        <?= conditionally_output_field($text_1, '<div>', '</div>') ?>
        <?= $cols > 1 ? conditionally_output_field($text_2, '<div>', '</div>') : ''; ?>
        <?= $cols > 2 ? conditionally_output_field($text_3, '<div>', '</div>') : ''; ?>
    </div>

</div>