<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package beechnut
 */

$site_logo = get_field('logo_full_white', 'option') ? get_field('logo_full_white', 'option') : '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0" />
	<?php wp_head(); ?>
	<link rel="stylesheet" href="https://use.typekit.net/oan3nwr.css">
</head>

<body <?php body_class(); ?>> 
<?php wp_body_open(); ?>

<div id="scrollPercentage"></div>
<div id="page" class="site">
	<?php if(!is_front_page()) : ?>

	<?php endif; ?>