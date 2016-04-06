<?php

include( get_template_directory() . '/classes.php' );
include( get_template_directory() . '/widgets.php' );

add_action( 'themecheck_checks_loaded', 'theme_disable_cheks' );
function theme_disable_cheks() {
	$disabled_checks = array( 'TagCheck', 'Plugin_Territory', 'CustomCheck', 'EditorStyleCheck' );
	global $themechecks;
	foreach ( $themechecks as $key => $check ) {
		if ( is_object( $check ) && in_array( get_class( $check ), $disabled_checks ) ) {
			unset( $themechecks[$key] );
		}
	}
}

if ( !isset( $content_width ) ) {
	$content_width = 900;
}

add_action( 'after_setup_theme', 'theme_localization' );
function theme_localization () {
	load_theme_textdomain( 'tvinsider', get_template_directory() . '/languages' );
}

/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support( 'title-tag' );

function theme_widget_init() {
	register_sidebar( array(
		'id'            => 'default-sidebar',
		'name'          => __( 'Default Sidebar', 'tvinsider' ),
		'before_widget' => '<div class="%2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'id'            => 'homepage-sidebar',
		'name'          => __( 'Home Page Sidebar - Top', 'tvinsider' ),
		'before_widget' => '<div class="homepage-widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>'
	) );
	
	register_sidebar( array(
		'id'            => 'homepage-bottom-sidebar',
		'name'          => __( 'Home Page Sidebar - Bottom', 'tvinsider' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'id'            => 'blank-sidebar',
		'name'          => __( 'Custom Page Sidebar', 'tvinsider' ),
		'before_widget' => '<div class="%2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'id'            => 'bottom1-sidebar',
		'name'          => __( 'Bottom Sidebar - Column 1', 'tvinsider' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'id'            => 'bottom2-sidebar',
		'name'          => __( 'Bottom Sidebar - Column 2', 'tvinsider' ),
		'before_widget' => '<div class="%2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar( array(
		'id'            => 'bottom3-sidebar',
		'name'          => __( 'Bottom Sidebar - Column 3', 'tvinsider' ),
		'before_widget' => '<div class="%2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
}
add_action( 'widgets_init', 'theme_widget_init' );

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
add_image_size( 't_812x522', 812, 522, true );
add_image_size( 't_314x228', 314, 228, true );
add_image_size( 't_234x170', 234, 170, true );
add_image_size( 't_330x240', 330, 240, true );
add_image_size( 't_666x486', 666, 486, true );
add_image_size( 't_727x530', 727, 530, true );
add_image_size( 't_195x195', 195, 195, true );
add_image_size( 't_1122x424', 1122, 424, true );
add_image_size( 't_1122x631', 1122, 631, true );
add_image_size( 't_203x169', 203, 169, true );

register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'tvinsider' ),
	'footer_topnav' => __( 'Footer Top Navigation', 'tvinsider' ),
	'footer_nav' => __( 'Footer Navigation', 'tvinsider' ),
) );

//Add [email]...[/email] shortcode
function shortcode_email( $atts, $content ) {
	return antispambot( $content );
}
add_shortcode( 'email', 'shortcode_email' );

//Register tag [template-url]
function filter_template_url( $text ) {
	return str_replace( '[template-url]', get_template_directory_uri(), $text );
}
add_filter( 'the_content', 'filter_template_url' );
add_filter( 'widget_text', 'filter_template_url' );

//Register tag [site-url]
function filter_site_url( $text ) {
	return str_replace( '[site-url]', home_url(), $text );
}
add_filter( 'the_content', 'filter_site_url' );
add_filter( 'widget_text', 'filter_site_url' );

if( class_exists( 'acf' ) && !is_admin() ) {
	add_filter( 'acf/load_value', 'filter_template_url' );
	add_filter( 'acf/load_value', 'filter_site_url' );
}

//Replace standard wp menu classes
function change_menu_classes( $css_classes ) {
	return str_replace( array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor', 'current_page_parent' ), 'active', $css_classes );
}
add_filter( 'nav_menu_css_class', 'change_menu_classes' );

//Allow tags in category description
$filters = array( 'pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description' );
foreach ( $filters as $filter ) {
	remove_filter( $filter, 'wp_filter_kses' );
}

//Make wp admin menu html valid
function wp_admin_bar_valid_search_menu( $wp_admin_bar ) {
	if ( is_admin() )
		return;

	$form  = '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" id="adminbarsearch"><div>';
	$form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
	$form .= '<input type="submit" class="adminbar-button" value="' . __( 'Search', 'tvinsider' ) . '"/>';
	$form .= '</div></form>';

	$wp_admin_bar->add_menu( array(
		'parent' => 'top-secondary',
		'id'     => 'search',
		'title'  => $form,
		'meta'   => array(
			'class'    => 'admin-bar-search',
			'tabindex' => -1,
		)
	) );
}
function fix_admin_menu_search() {
	remove_action( 'admin_bar_menu', 'wp_admin_bar_search_menu', 4 );
	add_action( 'admin_bar_menu', 'wp_admin_bar_valid_search_menu', 4 );
}
add_action( 'add_admin_bar_menus', 'fix_admin_menu_search' );

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function remove_comments_rss( $for_comments ) {
    return;
}
add_filter('post_comments_feed_link','remove_comments_rss');

function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'playlist', 'gallery', 'binge-guide');
	return $qv;
}
add_filter('request', 'myfeed_request');

//Disable comments on pages by default
function theme_page_comment_status( $post_ID, $post, $update ) {
	if ( !$update ) {
		remove_action( 'save_post_page', 'theme_page_comment_status', 10 );
		wp_update_post( array(
			'ID' => $post->ID,
			'comment_status' => 'closed',
		) );
		add_action( 'save_post_page', 'theme_page_comment_status', 10, 3 );
	}
}
add_action( 'save_post_page', 'theme_page_comment_status', 10, 3 );

//custom excerpt
function theme_the_excerpt() {
	global $post;
	
	if ( trim( $post->post_excerpt ) ) {
		the_excerpt();
	} elseif ( strpos( $post->post_content, '<!--more-->' ) !== false ) {
		the_content();
	} else {
		the_excerpt();
	}
}


remove_filter('the_content', 'wptexturize');
remove_filter('the_title', 'wptexturize');

//theme password form
function theme_get_the_password_form() {
	global $post;
	$post = get_post( $post );
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
	<p>' . __( 'This content is password protected. To view it please enter your password below:', 'tvinsider' ) . '</p>
	<p><label for="' . $label . '">' . __( 'Password:', 'tvinsider' ) . '</label> <input name="post_password" id="' . $label . '" type="password" size="20" /> <input type="submit" name="Submit" value="' . esc_attr__( 'Submit' ) . '" /></p></form>
	';
	return $output;
}
add_filter( 'the_password_form', 'theme_get_the_password_form' );

function base_scripts_styles() {
	$in_footer = true;
	// Loads JavaScript file with functionality specific.
	wp_enqueue_script( 'base-script', get_template_directory_uri() . '/js/jquery.main.js', array( 'jquery' ), '', $in_footer );

	// Loads our main stylesheet.
	wp_enqueue_style( 'base-style', get_stylesheet_uri(), array() );
	
	// Implementation stylesheet.
	wp_enqueue_style( 'base-theme', get_template_directory_uri() . '/theme.css', array() );	

}
add_action( 'wp_enqueue_scripts', 'base_scripts_styles' );

//theme options tab in appearance
if( function_exists( 'acf_add_options_sub_page' ) ) {
	acf_add_options_sub_page( array(
		'title'  => 'Theme Options',
		'parent' => 'themes.php',
	) );
}

//acf theme functions placeholders
if( !class_exists( 'acf' ) && !is_admin() ) {
	function get_field_reference( $field_name, $post_id ) { return ''; }
	function get_field_objects( $post_id = false, $options = array() ) { return false; }
	function get_fields( $post_id = false ) { return false; }
	function get_field( $field_key, $post_id = false, $format_value = true )  { return false; }
	function get_field_object( $field_key, $post_id = false, $options = array() ) { return false; }
	function the_field( $field_name, $post_id = false ) {}
	function have_rows( $field_name, $post_id = false ) { return false; }
	function the_row() {}
	function reset_rows( $hard_reset = false ) {}
	function has_sub_field( $field_name, $post_id = false ) { return false; }
	function get_sub_field( $field_name ) { return false; }
	function the_sub_field( $field_name ) {}
	function get_sub_field_object( $child_name ) { return false;}
	function acf_get_child_field_from_parent_field( $child_name, $parent ) { return false; }
	function register_field_group( $array ) {}
	function get_row_layout() { return false; }
	function acf_form_head() {}
	function acf_form( $options = array() ) {}
	function update_field( $field_key, $value, $post_id = false ) { return false; }
	function delete_field( $field_name, $post_id ) {}
	function create_field( $field ) {}
	function reset_the_repeater_field() {}
	function the_repeater_field( $field_name, $post_id = false ) { return false; }
	function the_flexible_field( $field_name, $post_id = false ) { return false; }
	function acf_filter_post_id( $post_id ) { return $post_id; }
}

add_filter('custom_menu_fields', 'custom_menu_options');
function custom_menu_options(){
	$fields = array(
		array(
			'type' => 'checkbox',
			'name' => 'hide_on_desktop',
			'label' => 'Hide item on desktop, using CSS'
		),
	);
	return $fields;
}

function string_limit_words($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) >= $word_limit) {
            array_pop($words);
            return implode(' ', $words).'...';
	} else {
            return implode(' ', $words);
        }
}

function new_excerpt_length($length) {return 18;}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {return '...';}
add_filter('excerpt_more', 'new_excerpt_more');

if (function_exists ('register_post_type')) {
	$labels = array(
		'name' => _x('Playlists','post type general name'),
		'singular_name' =>_x('Playlist','post type singular name'),
		'add_new' => _x('Add New', 'playlist'),
		'add_new_item' => __('Add New Item'),
		'edit_item' => __('Edit Item'),
		'new_item' => __('New Item'),
		'view_item' => __('View Item'),
		'search_items' => __('Search Items'),
		'not_found' => __('Not Found'),
		'not_found_in_trash' => __('Not Found In Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Playlists'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicy_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'playlist'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'has_archive' => true,
		'yarpp_support' => true,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
	);
	register_post_type('playlist', $args);
	
	$labels = array(
		'name' => _x('Binge Guides','post type general name'),
		'singular_name' =>_x('Binge Guide','post type singular name'),
		'add_new' => _x('Add New', 'binge-guide'),
		'add_new_item' => __('Add New Item'),
		'edit_item' => __('Edit Item'),
		'new_item' => __('New Item'),
		'view_item' => __('View Item'),
		'search_items' => __('Search Items'),
		'not_found' => __('Not Found'),
		'not_found_in_trash' => __('Not Found In Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Binge Guides'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicy_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'binge-guide'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'has_archive' => true,
		'taxonomies' => array('categories'), 
		'yarpp_support' => true,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
	);
	register_post_type('binge-guide', $args);

	$labels = array(
		'name' => _x('Galleries','post type general name'),
		'singular_name' =>_x('Gallery','post type singular name'),
		'add_new' => _x('Add New', 'binge-guide'),
		'add_new_item' => __('Add New Item'),
		'edit_item' => __('Edit Item'),
		'new_item' => __('New Item'),
		'view_item' => __('View Item'),
		'search_items' => __('Search Items'),
		'not_found' => __('Not Found'),
		'not_found_in_trash' => __('Not Found In Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Galleries'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicy_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'gallery'),
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => null,
		'has_archive' => true,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions'),
		'yarpp_support' => true,
		'taxonomies' => array('category')
	);
	register_post_type('gallery', $args);
	register_taxonomy_for_object_type('category', 'gallery');
}

function force_default_taxonomies () {
	register_taxonomy_for_object_type('category', 'gallery');
	register_taxonomy_for_object_type('category', 'binge-guide');
	register_taxonomy_for_object_type('category', 'playlist');
}
add_filter('init', 'force_default_taxonomies');


if (function_exists ('register_taxonomy')) {
	add_action( 'init', 'create_custom_taxonomies', 0 );
	function create_custom_taxonomies() {
		$labels1 = array(
			'name' => _x( 'Genres', 'taxonomy general name' ),
			'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Genres' ),
			'all_items' => __( 'All Genres' ),
			'parent_item' => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item' => __( 'Edit Genre' ), 
			'update_item' => __( 'Update Genre' ),
			'add_new_item' => __( 'Add New Genre' ),
			'new_item_name' => __( 'New Genre Name' ),
			'menu_name' => __( 'Genres' ),
		); 	
		register_taxonomy('genre',array('post', 'playlist', 'binge-guide', 'gallery'), array(
			'hierarchical' => true,
			'labels' => $labels1,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'genre' ),
		));
		$labels2 = array(
			'name' => _x( 'Shows', 'taxonomy general name' ),
			'singular_name' => _x( 'Show', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Shows' ),
			'all_items' => __( 'All Shows' ),
			'parent_item' => __( 'Parent Show' ),
			'parent_item_colon' => __( 'Parent Show:' ),
			'edit_item' => __( 'Edit Show' ), 
			'update_item' => __( 'Update Show' ),
			'add_new_item' => __( 'Add New Show' ),
			'new_item_name' => __( 'New Show Name' ),
			'popular_items' => NULL,
			'menu_name' => __( 'Shows' ),
		); 	
		register_taxonomy('show',array('post', 'playlist', 'binge-guide', 'gallery'), array(
			'hierarchical' => true,
			'labels' => $labels2,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'show' ),
			'capabilities' => array (
	            'manage_terms' => 'edit_posts', 
	            'edit_terms' => 'edit_posts',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'  
            )
		));
		$labels3 = array(
			'name' => _x( 'People', 'taxonomy general name' ),
			'singular_name' => _x( 'Person', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search People' ),
			'all_items' => __( 'All People' ),
			'parent_item' => __( 'Parent Person' ),
			'parent_item_colon' => __( 'Parent Person:' ),
			'edit_item' => __( 'Edit Person' ), 
			'update_item' => __( 'Update Person' ),
			'add_new_item' => __( 'Add New Person' ),
			'new_item_name' => __( 'New Person' ),
			'popular_items' => NULL,
			'menu_name' => __( 'Person' ),
		); 	
		register_taxonomy('people',array('post', 'playlist', 'binge-guide', 'gallery'), array(
			'hierarchical' => true,
			'labels' => $labels3,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'person' ),
			'capabilities' => array (
	            'manage_terms' => 'edit_posts', 
	            'edit_terms' => 'edit_posts',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'  
            )
		));
	}
}

//Adds galleries to archive pages
function query_post_type($query) {
  if(is_category()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','gallery'); 
		$query->set('post_type',$post_type);
		return $query;
    }
}
add_filter('pre_get_posts', 'query_post_type');

function get_popular_post_ids($args) {
	global $wpdb;
	$prefix = $wpdb->prefix . "popularposts";
	$where = "";
	$now = current_time('mysql');
	if(!isset($args['post_type'])) $args['post_type'] = 'post';

	/* Build the Query */
	$fields = "p.ID AS 'id', p.post_title AS 'title', p.post_date AS 'date', p.post_author AS 'uid', v.pageviews AS 'pageviews'";

	$from = "{$prefix}data v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";

	switch( $args['range'] ){
		case "yesterday":
			$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 DAY) ";
			break;
		case "daily":
			$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 DAY) ";
			break;
		case "weekly":
			$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 WEEK) ";
			break;
		case "monthly":
			$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 MONTH) ";
			break;
		default:
			$where .= "";
			break;
	}

	$where .= " AND p.post_type = '". $args['post_type'] ."'";
	$where .= " AND p.post_password = '' AND p.post_status = 'publish'";	

	$orderby = "ORDER BY pageviews DESC";

	$query = "SELECT {$fields} FROM {$from} {$where} {$orderby};";

	$result = $wpdb->get_results($query);

	$result_IDs = array();
	foreach ($result as $aPost) {
		$theID = $aPost->id;
		if ( !$theID == "" ) {
			$result_IDs[] = $theID;
		}
	}
	return($result_IDs);
}

function my_page_css_class($css_class, $page) {
    if((get_post_type() == 'playlist') || (get_post_type() == 'binge-guide')) {
        if ($page->object_id == get_option('page_for_posts')) {
            foreach ($css_class as $k => $v) {
                if ($v == 'active') unset($css_class[$k]);
            }
        }
    }
    return $css_class;
}
add_filter('nav_menu_css_class', 'my_page_css_class', 10, 2);

//Add More Featured Thumbnails
if (class_exists('MultiPostThumbnails')) {
	//posts
	new MultiPostThumbnails(array(
		'label' => 'Carousel',
		'id' => 'carousel',
		'post_type' => 'post'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Large',
		'id' => 'promo-large',
		'post_type' => 'post'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Small',
		'id' => 'promo-small',
		'post_type' => 'post'
	));
	new MultiPostThumbnails(array(
		'label' => 'Circle Promo',
		'id' => 'promo-circular',
		'post_type' => 'post'
	));
	//binge guides
	new MultiPostThumbnails(array(
		'label' => 'Promo Small',
		'id' => 'promo-small',
		'post_type' => 'binge-guide'
	));
	//playlists
	new MultiPostThumbnails(array(
		'label' => 'Circle Promo',
		'id' => 'promo-circular',
		'post_type' => 'playlist'
	));
	new MultiPostThumbnails(array(
		'label' => 'Carousel',
		'id' => 'carousel',
		'post_type' => 'playlist'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Large',
		'id' => 'promo-large',
		'post_type' => 'playlist'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Small',
		'id' => 'promo-small',
		'post_type' => 'playlist'
	));
	//galleries
	new MultiPostThumbnails(array(
		'label' => 'Circle Promo',
		'id' => 'promo-circular',
		'post_type' => 'gallery'
	));
	new MultiPostThumbnails(array(
		'label' => 'Carousel',
		'id' => 'carousel',
		'post_type' => 'gallery'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Large',
		'id' => 'promo-large',
		'post_type' => 'gallery'
	));
	new MultiPostThumbnails(array(
		'label' => 'Promo Small',
		'id' => 'promo-small',
		'post_type' => 'gallery'
	));
}

function nelio_rewrite_rules() {
	add_rewrite_rule( '^article/([0-9]+)/([^/]+)/?$', 'index.php?name=$matches[2]', 'top' );
	add_rewrite_rule( '^binge-guide/([0-9]+)/([^/]+)/?$', 'index.php?post_type=binge-guide&name=$matches[2]', 'top' );
	add_rewrite_rule( '^playlist/([0-9]+)/([^/]+)/?$', 'index.php?post_type=playlist&name=$matches[2]', 'top' );
	add_rewrite_rule( '^gallery/([0-9]+)/([^/]+)/?$', 'index.php?post_type=gallery&name=$matches[2]', 'top' );
}
add_action( 'init', 'nelio_rewrite_rules', 10 );

function nelio_extra_post_link( $permalink, $post ) {
	$matches = array(
		// post_type => (url_fragment,meta_name)
		'binge-guide' => array( 'binge-guide', '_nelio_bingeguideid' ),
		'playlist'    => array( 'playlist', '_nelio_playlistid' ),
		'post'        => array( 'article', '_nelio_articleid' ),
		'gallery'     => array( 'gallery', '_nelio_articleid' ),
	);

	if ( is_object( $post ) && $post->post_status == 'publish' ) {
		$match = false;
		foreach( $matches as $candidate => $aux )
			if ( $post->post_type == $candidate )
				$match = $candidate;
		if ( !$match )
			return $permalink;

		$_nelio_meta = get_post_meta( $post->ID, $matches[$match][1], true );
		if ( $_nelio_meta )
			$id = $_nelio_meta;
		else
			$id = $post->ID;
		$prefix = $matches[$match][0] . '/' . $id;

		if ( strpos( $permalink, home_url() ) === 0 )
			$permalink = str_replace( home_url(), '', $permalink );

		if ( strpos( $permalink, '/' . $matches[$match][0] ) === 0 )
			$permalink = str_replace( '/' . $matches[$match][0], '', $permalink );

		$permalink = home_url( $prefix . $permalink );
	}
	return $permalink;
}

/* FIXING PERMALINKS - FOR PRODUCTION ONLY */
$host = $_SERVER['SERVER_NAME'];
if (strpos($host, "tvinsider.com") !== false){
	add_filter( 'post_link',      'nelio_extra_post_link', 10, 2 );
	add_filter( 'post_type_link', 'nelio_extra_post_link', 10, 2 );
}

/* REDIRECT STORIES */
//and a custom field with name/value of direct_link/link is added. 
function create_external_permalink($link, $post) {
    $meta = get_post_meta( $post->ID, 'direct_link', TRUE);
	$url  = esc_url(filter_var($meta, FILTER_VALIDATE_URL));
    return $url ? $url : $link;
}
add_filter('post_link', 'create_external_permalink', 10, 2);


/* ACF ADMIN */
// Sorts admin
function my_relationship_query( $args, $field, $post ) {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}
add_filter('acf/fields/relationship/query', 'my_relationship_query', 10, 3);


//Sets up the admin jquery... 
function my_admin_enqueue_scripts() {
	wp_enqueue_script( 'my-admin-js', get_template_directory_uri() . '/js/admin.js', array(), '1.0.0', true );
}
//add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');
//...to allow for the custom field tvi_slug to be searched too
function my_relationship_query_add_slug( $args, $field, $object ) {
	$slug = get_field('tvi_slug', $object->ID); 
	$args['meta_key'] = $slug;
	//this variable is the one we need to capture with ajax: 
	$args['meta_value'] = 'news-onceuponatime0711';
    return $args;
}
//where we are stuck is getting the dynamic variable in there.
//add_filter('acf/fields/relationship/query', 'my_relationship_query_add_slug', 10, 3);

/* ADMIN CSS TWEAKS */
add_action('admin_head', 'css_tweak');
function css_tweak() {
  echo '<style>
	/* hides some text from the plugins page in the admin */
    .wp-plugin_note_user, .wp-plugin_note_date {
	    display:none;
    } 
	/* makes the Featured Image column a proper width */
    th#qfi-thumbnail {
		width: 10%;
	}
  </style>';
}


/*  REMOVE HENTRY */
// Don't know how this gets in here, but it tosses an error in Google Webmaster Tools
function remove_hentry( $classes ) {
	$classes = array_diff($classes, array('hentry'));
	return $classes;
}
add_filter( 'post_class', 'remove_hentry' );


/* TWEAKS FOR FIELDS TO SHOW ON EMBEDED IMAGES */
//inlude the description (which we call the credit) when embedding the image
function get_description( $attachment_id ) {
    $post_id = str_replace( 'attachment_', '', $attachment_id );
    $img     = get_post( (int) $post_id );
    if ( is_a( $img, 'WP_Post' ) )
        return wpautop( $img->post_content );
    return '';
}
function my_img_caption_shortcode( $empty, $attr, $content ){
	$attr = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => '',
		'description' => '',
	), $attr );
	$attr['description'] = strip_tags(get_description( $attr['id'] ));
	return '<div id="' . $attr['id'] . '" class="wp-caption ' . esc_attr( $attr['align'] ) . '" style="width: ' . ( 10 + (int) $attr['width'] ) . 'px;">'
	. do_shortcode( $content )
	. '<p class="wp-credit-text">' . $attr['description'] . '</p>'
	. '<p class="wp-caption-text">' . $attr['caption'] . '</p>'
	. '</div>';

}
add_filter( 'img_caption_shortcode', 'my_img_caption_shortcode', 10, 3 );

//Problem: the image caption disappear when there is no caption, so the credit also disppears. Beginnings of solution: 
// //whatmarkdid.com/php/default-image-captions-wordpress/
// //hookr.io/4.1.1/filters/disable_captions/


