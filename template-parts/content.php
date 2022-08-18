<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package beechnut
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		get_template_part('template-parts/section', null);
	?>

</article><!-- #post-<?php the_ID(); ?> -->
