<?php
    $section = 'messaging';
    $content_field = 'content_'.$section;
    
    get_template_part( 'template-parts/parts/content', null, array('field' => $content_field) );
?>