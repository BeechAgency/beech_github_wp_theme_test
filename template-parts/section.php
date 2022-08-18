<?php
if(have_rows('section')): 
    $n = 0;
    while(have_rows('section')): 
        the_row();
        $title = get_acf_value('title'); 
        $anchor = str_replace(' ', '', strtolower($title)); ?>

    <section class="section-<?= $n ?>" id="<?= $anchor; ?>">
        <div class="inner">
            <?= conditionally_output_field($title, '<h1>', '</h1>') ?>
            <!-- Content -->
            <?php 
                if(have_rows('content')):
                    while(have_rows('content')):
                        the_row();

                        $layout = get_row_layout();

                        get_template_part( 'template-parts/parts/content', $layout, array('layout' => $layout) );

                    endwhile; // End content loop
                endif; // End content loop if.
            ?>
        </div><!-- end: inner -->
    </section><!-- end: section -->

<?php
    $n++;
    endwhile;  
endif; ?>