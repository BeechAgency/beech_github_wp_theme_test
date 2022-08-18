<?php
    $section = 'color';

if(have_rows('palettes')): ?>
<div class="row-content">
<?php 
    while(have_rows('palettes')): 
        the_row();
        
        get_template_part( 'template-parts/parts/palette');
        
    endwhile; ?>
</div>
<?php endif; 
?>