<?php
    $title = get_acf_value('_title');
    $para_left = get_acf_value('_para_left');
    $para_right = get_acf_value('_para_right');

    $anchor = get_acf_value('_anchor');
?>

<div class="content content-paragraph_cols" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>
    <div>
        <div><?= $para_left ?></div>
        <div><?= $para_right ?></div>
    </div>
</div>