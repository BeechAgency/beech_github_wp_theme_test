<?php
/**
 * beechnut functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package beechnut
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function beechnut_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on beechnut, use a find and replace
		* to change 'beechnut' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'beechnut', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'beechnut' ),
			'footer-menu' => esc_html__( 'Footer', 'beechnut' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'beechnut_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'beechnut_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function beechnut_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beechnut_content_width', 640 );
}
add_action( 'after_setup_theme', 'beechnut_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function beechnut_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'beechnut' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'beechnut' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'beechnut_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function beechnut_scripts() {
	wp_enqueue_style( 'beechnut-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'flickity', get_template_directory_uri().'/css/vendor/flickity.css', array(), _S_VERSION );

	wp_style_add_data( 'beechnut-style', 'rtl', 'replace' );

	wp_enqueue_script( 'beechnut-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'beechnut-blocks', get_template_directory_uri() . '/js/blocks.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'header-carousel', get_template_directory_uri() . '/js/home-carousel.js', array('flickity'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( get_post_type() === 'project' ) {
		wp_enqueue_script('side-scroll', get_template_directory_uri() . '/js/side-scroll.js', array(), _S_VERSION, true ); 
	}
}
add_action( 'wp_enqueue_scripts', 'beechnut_scripts' );


/**
 * Add goodness to deal with defering scripts
 */
add_filter( 'script_loader_tag', 'beechnut_defer_scripts', 10, 3 );
function beechnut_defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = array( 
		'blocks',
		'home-carousel',
		'side-scroll'
	);

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
} 

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );



// Callback function to insert 'styleselect' into the $buttons array
function beechnut_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'beechnut_mce_buttons_2' );

// Callback function to filter the MCE settings
function beechnut_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Paragraph - Standard',  
			'block' => 'p',  
			'classes' => '',
			'wrapper' => false,
			
		),  
		array(  
			'title' => 'Paragraph - Large',  
			'block' => 'p',  
			'classes' => 'lg',
			'wrapper' => false,
			
		),  
		array(  
			'title' => 'Paragraph - Small',  
			'block' => 'p',  
			'classes' => 'sm',
			'wrapper' => false,
		),
		array(  
			'title' => 'Button',  
			'block' => 'a',  
			'classes' => 'button',
			'wrapper' => true,
		),
		array(  
			'title' => 'Button - white',  
			'block' => 'a',  
			'classes' => 'button has-black-color has-white-background-color',
			'wrapper' => true,
		)
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = wp_json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'beechnut_mce_before_init_insert_formats' );  




// Our custom post type function
function create_posttype() {
  
    register_post_type( 'budgets',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Budgets' ),
                'singular_name' => __( 'Budget' )
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'budgets'),
            'show_in_rest' => true,
			'menu_icon' => 'dashicons-money-alt',	
			'taxonomies'  => array( 'category' )
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


function enqueue_the_calculator_script() {
	global $pagenow;

	if($pagenow === 'post.php' || $pagenow === 'post-new.php') {
		wp_enqueue_script( 'beechnut-calculator', get_template_directory_uri() . '/js/calculator.js', array('acf'), _S_VERSION, true );
	}
}

add_action( 'admin_enqueue_scripts', 'enqueue_the_calculator_script');

// Add the columns for the budget post type
add_filter( 'manage_budgets_posts_columns', 'beech_brand_filter_posts_columns' );
function beech_brand_filter_posts_columns( $columns ) {
	$date = $columns['date'];
	$categories = $columns['categories'];

	unset($columns['date']);
	unset($columns['categories']);
	/*
	$columns = array(
		'cb' => $columns['cb'],
		'image' => __( 'Image' ),
		'title' => __( 'Title' ),
		'price' => __( 'Price', 'smashing' ),
		'area' => __( 'Area', 'smashing' ),
	);*/

	$columns['bbudgets_client'] = __( 'Client Name' );
	$columns['bbudgets_proposed'] = __( 'Proposed' );
	$columns['categories'] = $categories;
	$columns['date'] = $date;

	return $columns;
}

/// Populate the columns
add_action( 'manage_budgets_posts_custom_column', 'beech_brand_budgets_column', 10, 2);
function beech_brand_budgets_column( $column, $post_id ) {
  // Image column
  if ( 'bbudgets_client' === $column ) {
    echo get_field('client_name', $post_id);
  }

  if ( 'bbudgets_proposed' === $column ) {
    echo '$'.get_field('proposed', $post_id);
  }
}


add_filter( 'manage_edit-budgets_sortable_columns', 'beech_brand_budgets_sortable_columns');
function beech_brand_budgets_sortable_columns( $columns ) {
  $columns['bbudgets_client'] = 'bbudgets_client';
  $columns['bbudgets_proposed'] = 'bbudgets_proposed';
  return $columns;
}

add_action( 'pre_get_posts', 'beech_brand_posts_orderby' );
function beech_brand_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  
  if ( 'bbudgets_client' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'client_name' );
    $query->set( 'meta_type', 'string' );
  }

  if ( 'bbudgets_proposed' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'proposed' );
    $query->set( 'meta_type', 'numeric' );
  }
}

/* Updater 
add_action( 'after_setup_theme', function() {
	get_template_part( 'inc/classes/Updater' );
});
*/


/* 
 * Automatic theme updates from the GitHub repository
 * Care of https://gist.github.com/slfrsn/a75b2b9ef7074e22ce3b.
 */ 

add_filter('pre_set_site_transient_update_themes', 'automatic_GitHub_updates', 100, 1);
function automatic_GitHub_updates($data) {
  // Theme information
  $theme   = get_stylesheet(); // Folder name of the current theme
  $current = wp_get_theme()->get('Version'); // Get the version of the current theme
  // GitHub information
  $user = 'BeechAgency'; // The GitHub username hosting the repository
  $repo = 'beech_github_wp_theme_test'; // Repository name as it appears in the URL
  // Get the latest release tag from the repository. The User-Agent header must be sent, as per
  // GitHub's API documentation: https://developer.github.com/v3/#user-agent-required
  $file = @json_decode(@file_get_contents('https://api.github.com/repos/'.$user.'/'.$repo.'/releases/latest', false,
      stream_context_create(['http' => ['header' => "User-Agent: ".$user."\r\n"]])
  ));
  if($file) {
	$update = filter_var($file->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    // Only return a response if the new version number is higher than the current version
    if($update > $current) {
  	  $data->response[$theme] = array(
	      'theme'       => $theme,
	      // Strip the version number of any non-alpha characters (excluding the period)
	      // This way you can still use tags like v1.1 or ver1.1 if desired
	      'new_version' => $update,
	      'url'         => 'https://github.com/'.$user.'/'.$repo,
	      'package'     => $file->assets[0]->browser_download_url,
      );
    }
  }
  return $data;
}