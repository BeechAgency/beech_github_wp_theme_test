<?php 
    $text = get_acf_value('_text'); 
    
    $anchor = get_acf_value('_anchor');
?>

<div class="content content-big_text" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($text, '<h3>', '</h3>') ?>
</div>