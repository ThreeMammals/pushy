<?php
/*
Plugin Name: Pushy
Plugin URI: http://www.threemammals.com/
Description: TBC...
Author: Tom Pallister
Version: 0.0.0
Author URI: http://github.com/TomPallister/
 */

include plugin_dir_path(__FILE__) . '/src/Pushy.php';

// This hook runs on every post save, update etc
add_action('save_post', 'save_post_hook_tomgp', 10, 3);

// This hook runs when a post is trashed
add_action('wp_trash_post', 'trash_post_hook_tomgp', 10);

// This hook runs when a post is restored
add_action('untrash_post', 'untrash_post_hook_tomgp', 10);

// This hook runs when a trashed post is deleted
add_action('delete_post', 'delete_post_hook_tomgp', 10);

// This hook runs whenever a CRUD action happens on categories
add_action('add_category_form_pre', 'update_category_function_tomgp', 10, 1);
add_action('edit_category', 'update_category_function_tomgp', 10, 1);
add_action('delete_category', 'update_category_function_tomgp', 10, 1);
add_action('create_category', 'update_category_function_tomgp', 10, 1);

// This hook runs whenever a menu is updated
add_action('wp_update_nav_menu', 'update_nav_menu_function_tomgp', 10);

// This hook runs whenever a menu is deleted
add_action('wp_delete_nav_menu', 'delete_nav_menu_function_tomgp', 10);
