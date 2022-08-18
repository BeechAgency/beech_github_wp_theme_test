<?php 
    $title = get_acf_value('_title'); 
    $anchor = get_acf_value('_anchor');
?>
<div class="content <?= get_row_layout(); ?>" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>
    <?php 
        $count = count( get_sub_field('_images') );

        if(have_rows('_images')): 
        ?>
    <div class="row-nowrap cols-<?= $count ?>">
    <?php
        while(have_rows('_images')): 
            the_row(); 
            $fill = get_acf_value('_fill'); 
            $image = get_acf_image('_image'); 
            $caption = get_acf_value('_caption');
        ?>
        <figure class="image-<?= $fill ?>">
            <?= $image ?>
            <?= conditionally_output_field($caption, '<figcaption>', '</figcaption>') ?>
        </figure>
        <?php
        endwhile; ?>
    </div><!-- end: color-grid -->
    <?php endif; ?>
</div>