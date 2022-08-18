<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package beechnut
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<?php  get_template_part('template-parts/header', 'main'); ?>

	<?php #guttentest_post_thumbnail(); ?>

	<div class="entry-content">
	<?php if(have_rows('content_block')):?>

		<?php $c = 0; while(have_rows('content_block')): $c++;?> 

			<?php the_row();

				//get_template_part( 'template-parts/content-blocks/'.get_row_layout(), '' );
				include(dirname(__DIR__).'/template-parts/content-blocks/'.get_row_layout().'.php');
			?>

		<?php endwhile;
	endif; ?>


		<?php
		the_content();
		/*
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'guttentest' ),
				'after'  => '</div>',
			)
		); */
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'guttentest' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
