<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package beechnut
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function beechnut_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'beechnut_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function beechnut_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'beechnut_pingback_header' );

/**
 * Add functions to handle ACF stuff
 */

function get_acf_value($field, $type = 'sub', $postId = null) {
    if($type === 'sub') {
        return !empty(get_sub_field($field, $postId)) ? get_sub_field($field, $postId) : '';
    } else {
        return !empty(get_field($field, $postId)) ? get_field($field, $postId) : '';
    }

}
function get_acf_image($field, $size = 'full', $type = 'sub', $postId = null, $classes = null) {
    if($type === 'sub') {
	    return get_sub_field($field, $postId) ? wp_get_attachment_image(get_sub_field($field, $postId), $size, 0, array('title'=> '')) : ''; 
    } else {
	    return get_field($field, $postId) ? wp_get_attachment_image(get_field($field, $postId), $size, 0, array('title'=> '', 'class'=> $classes)) : ''; 
    }
}

/* Youtube ID */
function get_youtube_id($url) {

    $url_components = parse_url($url);
    parse_str($url_components['query'], $params);

    return $params['v'];
}

/* Args decifer */
function get_args_value($args, $prop) {
    return !empty( $args[ $prop] ) ? $args[ $prop ] : '';
}

/* Helper for wrapping stuff */
function conditionally_output_field($value, $openTag, $closeTag) {
    if(empty($value)) return;

    return $openTag.$value.$closeTag;
}

/**
 *  Add some goodstuff to the Tiny MCE
 */ 
function beechnut_change_mce_block_formats( $init ) {
	$block_formats = array(
		'Paragraph=p',
		'Paragraph Large=p-p2',
		'Heading 1=h1',
		'Heading 2=h2',
		'Heading 3=h3',
		'Heading 4=h4',
		'Heading 5=h5',
		'Heading 6=h6',
		'Preformatted=pre',
		'Code=code',
	);
	$init['block_formats'] = implode( ';', $block_formats );
	
	//var_dump($init['block_formats']);
 
	return $init;
}
add_filter( 'tiny_mce_before_init', 'beechnut_change_mce_block_formats' );

function beechnut_theme_after_wp_tiny_mce() {
?>
    <script type="text/javascript">
		console.log('tinymce init')
        jQuery( document ).on( 'tinymce-editor-init', function( event, editor ) {
            tinymce.activeEditor.formatter.register( 'p-p2', {
                block : 'p',
                classes : 'p2',
				wrapper : true
            } );
        } );
    </script>
<?php
}
add_action( 'after_wp_tiny_mce', 'beechnut_theme_after_wp_tiny_mce' );
/* read this and fix it up here https://wordpress.org/support/topic/wysiwyg-custom-buttons-not-showing/ */

/* Set the C var in the rows from args */
function beechnut_rows_set_c($args) {

    $c = !empty( $args['c'] ) ? (int) $args['c'] : 0;

    return $c;
}

function placeholder_img($width = 1200, $height = 900) {
    echo 'https://picsum.photos/'.$width.'/'.$height;
}

/* Add color picker to the ACF WYSIWYG editor 
add_filter( 'acf/fields/wysiwyg/toolbars' , 'bwaa_add_acf_color'  );
function bwaa_add_acf_color( $toolbars ) {
    array_unshift( $toolbars['Basic' ][1], 'forecolor' );
    return $toolbars;
} */
/* Default brand colors for MCE color picker 
function bwaa_mce4_options($init) {

    $custom_colours = '
        "333f4c", "Off Black",
        "fff046", "Yellow",
        "f0f0e6", "Tan",
        "0144CB", "Blue",
        "6ce6ff", "Light Blue",
        "058c1d", "Green",
        "91e83a", "Light Green",
        "f21905", "Red",
        "ff7f00", "Orange",
        "fdb034", "Light Orange",
        "d297fd", "Purple",
        "ffa3ff", "Pink",
        "6ce7ff99", "Light Blue Tint",
        "d297fd99", "Purple Tint",
        "333f4c33", "Off Black Tint",
        "000000", "Black",
        "ffffff", "White"
    ';

    // build colour grid default+custom colors
    $init['textcolor_map'] = '['.$custom_colours.']';

    // change the number of rows in the grid if the number of colors changes
    // 8 swatches per row
    $init['textcolor_rows'] = 3;

    return $init;
}
add_filter('tiny_mce_before_init', 'bwaa_mce4_options');*/