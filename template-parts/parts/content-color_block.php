<?php 
    $title = get_acf_value('_title'); 
    $anchor = get_acf_value('_anchor');
?>

<div class="content <?= get_row_layout(); ?>" <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>
    <?php 
        $count = count( get_sub_field('_colors') );

        if(have_rows('_colors')): ?>
    <div class="row-nowrap cols-<?= $count ?>">
    <?php
        while(have_rows('_colors')): 
            the_row();
            $name = get_acf_value('_name');
            $hex = get_acf_value('_hex');
            $pms = get_acf_value('_pms');
            $rgb = get_acf_value('_rgb');
            $cmyk = get_acf_value('_CMYK');
        ?>
        <div class="color-swatch <?= $hex ?> <?= get_acf_value('_text'); ?>" style="background-color: <?= $hex ?>;">
            <?= conditionally_output_field($name, '<h4>', '</h4>') ?>
            <?= conditionally_output_field($pms, '<span class="pms">PMS ', '</span>') ?>
            <?= conditionally_output_field($cmyk, '<span class="cmyk">CMYK ', '</span>') ?>
            <?= conditionally_output_field($hex, '<span class="hex">', '</span>') ?>
            <?= conditionally_output_field($rgb, '<span class="rgb">RGB ', '</span>') ?>
        </div>
        <?php
        endwhile; ?>
    </div><!-- end: color-grid -->
    <?php endif; ?>
</div>