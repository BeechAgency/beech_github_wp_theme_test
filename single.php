<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package beechnut
 */

get_header();

get_template_part( 'template-parts/layout-nav' );
?>

	<main id="primary" class="site-main brand">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_template_part( 'template-parts/layout-aside' );

get_footer();
