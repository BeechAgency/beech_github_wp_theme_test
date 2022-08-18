<?php
/**
 * The side nav layout
 *
 * @package beechnut
 */
?>

<nav class="sidebar-nav fixed has-white-background-color closed" id="nav">
    <div class="inner">
        <button class=""><span class="material-symbols-outlined">menu</span></button>
        <ul>
            <li>
                <a href="<?= get_acf_value('client_site', 'main', null); ?>">
                    <?= get_acf_image('client_icon', 'full', 'main' , null, '') ?>
                </a>
            </li>
            <li class="search" style="display: none">
                <label><input type="search" name="search" placeholder="Search" /></label>
            </li>
            <?php 
                if(have_rows('section')): 
                    $n = 0;
                    while(have_rows('section')): 
                        the_row();
                        $title = get_acf_value('title'); 
                        $anchor = str_replace(' ', '', strtolower($title)); ?>

            <li data-menu-for="#<?= $anchor ?>">
                <h4><a href="#<?= $anchor ?>"><?= $title ?></a></h4>
                <?php 
                if(have_rows('content')): ?>
                <ul>
                <?php    
                    while(have_rows('content')):
                        the_row(); 
                        $title = get_acf_value('_title'); 
                        $anchor = get_acf_value('_anchor');

                        if(!empty($anchor)):
                ?>
                    <li data-menu-for="#<?= $anchor; ?>">
                        <a href="#<?= $anchor; ?>"><?= $title ?></a>
                    </li>

                <?php   endif;
                    endwhile; // End content loop ?>
                </ul>
            <?php endif; // End content loop if. ?>
            </li>  
            <?php
                    endwhile; // End: Section WHILE
                endif; // End: Section IF
            ?>
        </ul>

        <footer class="<?= the_ID(); ?>">
            <a href="https://beech.agency" class="footer-logo"><img src="<?= get_template_directory_uri() ?>/images/beech-round.png" /> hi@beech.agency</a>
        </footer><!-- #colophon -->
    </div>
</nav>