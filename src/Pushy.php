<?php
declare(strict_types=1);

namespace Pushy;

// This hook runs on every post save, update etc
function save_post_hook_tomgp( $post_ID, $post, $update ) {
	$json = wp_json_encode( $post);
	file_put_contents('/var/www/html/data/save_post_hook_tomgp.json', $json);
  }
add_action( 'save_post', 'save_post_hook_tomgp', 10, 3 );

// This hook runs when a post is trashed
function trash_post_hook_tomgp( $post_id ) {
    $json = wp_json_encode( $post_id);
	file_put_contents('/var/www/html/data/trash_post_hook_tomgp.json', $json);
}
add_action( 'wp_trash_post', 'trash_post_hook_tomgp', 10 );


// This hook runs when a post is restored
function untrash_post_hook_tomgp( $post_id ) {
    $json = wp_json_encode( $post_id);
	file_put_contents('/var/www/html/data/untrash_post_hook_tomgp.json', $json);
}
add_action( 'untrash_post', 'untrash_post_hook_tomgp', 10 );

// This hook runs when a trashed post is deleted
function delete_post_hook_tomgp( $pid ) {
	$json = wp_json_encode( $pid);
	file_put_contents('/var/www/html/data/delete_post_hook_tomgp.json', $json);
}
add_action( 'delete_post', 'delete_post_hook_tomgp', 10 );


// This hook runs whenever a CRUD action happens on categories
function update_category_function_tomgp($category_id) {
    $categories = get_categories(array(
		'hide_empty' => 0
	));

	$json = wp_json_encode( $categories);
	file_put_contents('/var/www/html/data/update_category_function_tomgp.json', $json);
}
add_action('add_category_form_pre', 'update_category_function_tomgp', 10, 1);
add_action('edit_category', 'update_category_function_tomgp', 10, 1);
add_action('delete_category', 'update_category_function_tomgp', 10, 1);
add_action( 'create_category', 'update_category_function_tomgp', 10, 1 );

// This hook runs whenever a menu is updated
function update_nav_menu_function_tomgp($menu_id) {
	$menu_items = wp_get_nav_menu_items($menu_id);
	$json = wp_json_encode( $menu_items);
	file_put_contents('/var/www/html/data/update_nav_menu_function_tomgp.json', $json);
}
add_action( 'wp_update_nav_menu', 'update_nav_menu_function_tomgp', 10);

// This hook runs whenever a menu is deleted
function delete_nav_menu_function_tomgp($menu_id) {
	$json = wp_json_encode( $menu_id);
	file_put_contents('/var/www/html/data/delete_nav_menu_function_tomgp.json', $json);
}
add_action( 'wp_delete_nav_menu', 'delete_nav_menu_function_tomgp', 10);

