<?php
 $images_field = get_args_value($args, 'field');
    
if(have_rows($images_field)):
?>
<div class="row-content">
<?php 
	while(have_rows($images_field)): 
		the_row();
		get_template_part( 'template-parts/parts/content-image' );

	endwhile; ?>
</div>
<?php endif; ?>
