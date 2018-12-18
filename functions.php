<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:


if ( ! function_exists( 'chld_thm_cfg_parent_css' ) ):
	// wp_enqueue_style( 'dashicons' );
	function chld_thm_cfg_parent_css() {
		wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'dashicons' ) );
		wp_enqueue_style( 'custom-style', trailingslashit( get_stylesheet_directory_uri() ) . 'custom-style.css', [ 'fontawesome' ] );
	}
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );


/**
 * Wistia player customizations
 */

function wistia_customizations_scripts() {
	wp_enqueue_script( 'wistia-player', get_stylesheet_directory_uri() . '/js/wistia-player.js', array( 'jquery' ), 1.3, true );

}

add_action( 'wp_enqueue_scripts', 'wistia_customizations_scripts' );


define( 'BP_AVATAR_THUMB_WIDTH', 40 );

if ( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
		'id'            => 'learndash_sidebar',
		'name'          => 'Course Sidebar',
		'before_widget' => '<div class="learndash-sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'id'            => 'blog_sidebar',
		'name'          => 'Blog Sidebar',
		'before_widget' => '<div class="blog-sidebar">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}


add_filter( 'woocommerce_account_menu_items', 'misha_sort_menu' );
function misha_sort_menu( $menu_links ) {

	$menu_links = array(
		'edit-account'    => 'My Account',
		'orders'          => 'Orders',
		'subscriptions'   => 'Subscriptions',
		'edit-address'    => 'Addresses',
		'payment-methods' => 'Payment Methods',
		'vat-number'      => 'VAT Number',
	);

	return $menu_links;

}


add_filter( 'woocommerce_account_menu_items', 'misha_one_more_link' );
function misha_one_more_link( $menu_links ) {

	// we will hook "anyuniquetext123" later
	$new = array( 'anyuniquetext123' => 'Course Dashboard' );

	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

	// array_slice() is good when you want to add an element between the other ones
	$menu_links = array_slice( $menu_links, 0, 1, true )
	              + $new
	              + array_slice( $menu_links, 0, null, true );

	return $menu_links;


}

add_filter( 'woocommerce_get_endpoint_url', 'misha_hook_endpoint', 10, 4 );
function misha_hook_endpoint( $url, $endpoint, $value, $permalink ) {

	if ( $endpoint === 'anyuniquetext123' ) {

		// ok, here is the place for your custom URL, it could be external
		$url = 'https://javascriptforwp.com/dashboard/';

	}

	return $url;

}

add_filter( 'body_class', 'bbloomer_wc_product_cats_css_body_class' );

function bbloomer_wc_product_cats_css_body_class( $classes ) {
	if ( is_singular( 'product' ) ) {
		$custom_terms = get_the_terms( 0, 'product_cat' );
		if ( $custom_terms ) {
			foreach ( $custom_terms as $custom_term ) {
				$classes[] = 'product_cat_' . $custom_term->slug;
			}
		}
	}

	return $classes;
}

if ( ( isset( $_GET['action'] ) && $_GET['action'] != 'logout' ) || ( isset( $_POST['login_location'] ) && ! empty( $_POST['login_location'] ) ) ) {
	add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
	function my_login_redirect() {
		$location = $_SERVER['HTTP_REFERER'];
		wp_safe_redirect( $location );
		exit();
	}
}

// END ENQUEUE PARENT ACTION

function jfw_show_course_message_if_user_has_access() {
	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( ! jfw_user_can_access_course() ) {
		return;
	}

	echo '<div class="user-bought">You have access to this course. Click <a href="' . esc_url( jfw_get_course_link() ) . '">here</a> to go to the course.</div>';
}

add_action( 'woocommerce_before_single_product', 'jfw_show_course_message_if_user_has_access', 30 );

function jfw_user_can_access_course() {
	$has_access      = false;
	$product_courses = get_post_meta( get_the_ID(), '_related_course', true );
	if ( empty( $product_courses ) || empty( $product_courses[0] ) ) {
		return $has_access;
	}

	foreach ( (array) $product_courses as $course ) {
		$has_access = sfwd_lms_has_access( $course, get_current_user_id() );
		if ( false === $has_access ) {
			break;
		}
	}

	return $has_access;
}

function jfw_update_product_link_to_go_to_course( $link ) {
	if ( jfw_user_can_access_course() ) {
		return jfw_get_course_link();
	}

	return $link;
}

add_filter( 'woocommerce_loop_product_link', 'jfw_update_product_link_to_go_to_course' );

function jfw_maybe_remove_cart_link( $link_html ) {
	if ( jfw_user_can_access_course() ) {
		return '';
	}

	return $link_html;
}

add_filter( 'woocommerce_loop_add_to_cart_link', 'jfw_maybe_remove_cart_link' );

function jfw_get_course_link() {
	$url             = get_the_permalink();
	$product_courses = get_post_meta( get_the_ID(), '_related_course', true );
	if ( ! empty( (array) $product_courses[0] ) ) {
		$url = get_the_permalink( $product_courses[0] );
	}

	return $url;
}

function jfw_hide_annual_membership_from_courses_page( $query ) {
	$user                     = get_userdata( get_current_user_id() );
	$annual_member_product_id = 47866;
	if ( wc_customer_bought_product( $user->user_email, $user->ID, $annual_member_product_id ) ) {
		$query->set( 'post__not_in', array( $annual_member_product_id ) );
	}

	return $query;

}

add_action( 'woocommerce_product_query', 'jfw_hide_annual_membership_from_courses_page' );
