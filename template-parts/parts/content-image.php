<?php 
    $title = get_acf_value('_title'); 
    $caption = get_acf_value('_caption'); 
    $fit = get_acf_value('fit'); 
    $image = get_acf_image('_image'); 
    
    $anchor = get_acf_value('_anchor');
?>

<div class="content content-image img-<?=  $fit ?>" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>
    <figure>
        <?= $image ?>
        <?= conditionally_output_field($caption, '<figcaption>', '</figcaption>') ?>
    </figure>
</div>