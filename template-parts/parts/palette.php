<?php 
    $title = get_acf_value('_title'); 
    $text = get_acf_value('_text'); 
    
    $anchor = get_acf_value('_anchor');
?>
<div class="content palette"  <?= conditionally_output_field($anchor, 'id="', '"') ?>>
    <?= conditionally_output_field($title, '<h4>', '</h4>') ?>
    <?= conditionally_output_field($text, '<div>', '</div>') ?>
    <?php 
        if(have_rows('_colors')): ?>
    <div class="color-grid">
    <?php
        $grid_col = 1;
        $grid_row = 1;

        while(have_rows('_colors')): 
            the_row();
            $color = get_acf_value('_color');
            $name = get_acf_value('_name');
            $pms = get_acf_value('_pantone');
            $rgb = get_acf_value('_rgb');
            $cmyk = get_acf_value('_cmyk');
            $hex = get_acf_value('_hex');
            $rows = get_acf_value('_rows');
            $cols = get_acf_value('_cols');
            $label = get_acf_value('_label');

            //$rows = $rows > 1 ? $rows + 1 : $rows;

            $col_css = $cols > 1 ? 'grid-column : auto / span '.$cols.';' : '';
            $row_css = $rows > 1 ? 'grid-row : auto / span '.$rows.';' : '';

        ?>
        <div class="color-swatch <?= $label ?>" style="background-color: <?= $color ?>; <?= $col_css ?> <?= $row_css ?>">
            <?= conditionally_output_field($name, '<h6>', '</h6>') ?>
            <?= conditionally_output_field($pms, '<span class="pms">PMS ', '</span>') ?>
            <?= conditionally_output_field($hex, '<span class="hex">', '</span>') ?>
            <?= conditionally_output_field($rgb, '<span class="rgb">RGB ', '</span>') ?>
            <?= conditionally_output_field($cmyk, '<span class="cmyk">CMYK ', '</span>') ?>
        </div>
        <?php
        endwhile; ?>
    </div><!-- end: color-grid -->
    <?php endif; ?>
</div><!-- end: palette -->