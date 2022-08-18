<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package beechnut
 */

get_header();

?>
<main id="primary" class="site-main has-black-background-color has-white-color">
	<div class="home__block">

			<div class="vh-100 wrapper v-center text-center">
				<h1 class="text-center mega uber-logo" data-text="BEECH"><img src='<?= get_template_directory_uri()."/images/beech-logo-white.svg"; ?>' /></h1>
			</div>

	</div>	
</main><!-- #main -->

<?php
get_footer();
