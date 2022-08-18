<?php
 $content_field = get_args_value($args, 'field');
    
if(have_rows($content_field)): ?>
<div class="row-content">
<?php 
	while(have_rows($content_field)): 
		the_row();

		if($layout = get_row_layout()):
			get_template_part( 'template-parts/parts/content', $layout );
		endif;

	endwhile; ?>
</div>
<?php endif; ?>
