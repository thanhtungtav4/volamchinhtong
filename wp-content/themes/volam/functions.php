<?php
/**
 * volam functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package volam
 */
require_once( get_stylesheet_directory() . '/inc/optimize.php' );
require_once( get_stylesheet_directory() . '/inc/style.php' );

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
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
			'post-thumbnails'
		)
	);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function volam_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'volam' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'volam' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'volam_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function volam_scripts() {
	wp_enqueue_style( 'volam-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'volam-style', 'rtl', 'replace' );

	wp_enqueue_script( 'volam-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'volam_scripts' );

// add primary menu
if ( ! function_exists( 'mytheme_register_nav_menu' ) ) {

	function mytheme_register_nav_menu(){
		register_nav_menus( array(
	    	'primary_menu' => __( 'Primary Menu', 'text_domain' ),
	    	'footer_menu'  => __( 'Footer Menu', 'text_domain' ),
		) );
	}
	add_action( 'after_setup_theme', 'mytheme_register_nav_menu', 0 );
}


if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
			'page_title'    => 'Theme General Settings',
			'menu_title'    => 'Theme Settings',
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      => false
	));

	// acf_add_options_sub_page(array(
	// 		'page_title'    => 'Theme Header Settings',
	// 		'menu_title'    => 'Header',
	// 		'parent_slug'   => 'theme-general-settings',
	// ));

	// acf_add_options_sub_page(array(
	// 		'page_title'    => 'Theme Footer Settings',
	// 		'menu_title'    => 'Footer',
	// 		'parent_slug'   => 'theme-general-settings',
	// ));

}

//REMOVE GUTENBERG BLOCK LIBRARY CSS FROM LOADING ON FRONTEND
function remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' ); // REMOVE WOOCOMMERCE BLOCK CSS
	wp_dequeue_style( 'global-styles' ); // REMOVE THEME.JSON
	}
	add_action( 'wp_enqueue_scripts', 'remove_wp_block_library_css', 100 );