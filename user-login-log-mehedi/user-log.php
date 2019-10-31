<?php
/*
Plugin Name: User Login Data
Plugin URI: #
Description: This is a test plugin to show user activity log
Version: 1.0
Author: Mehedi hasan
Author URI: #
License: GPLv2 or later
Text Domain: ulogdata
Domain Path: /languages/
*/
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// load text domain
function ulogdata_load_textdomain() {
	load_plugin_textdomain( 'ulogdata', false, dirname( __FILE__ ) . "/languages" );
}
add_action( "plugins_loaded", "ulogdata_load_textdomain" );


// Load includes files
include( MY_PLUGIN_PATH . 'includes/class.persons-table.php');
include( MY_PLUGIN_PATH . 'includes/ulog-admin-menu-page.php');



// init datebase files
function ulog_create_new_db () {
   global $wpdb;

   $table_name = $wpdb->prefix . "ulog_history";
   $sql = "CREATE TABLE $table_name (
    tuid INT(9) NOT NULL AUTO_INCREMENT,
    tuuser_name varchar(255) NOT NULL,
    tuuser_role varchar(255) NOT NULL,
    tuuser_ip_address varchar(255) NOT NULL,
    tuuser_status varchar(255) NOT NULL,
    user_id INT NOT NUll,
    PRIMARY KEY  (tuid),

    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL

  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
}
register_activation_hook( __FILE__, 'ulog_create_new_db' );

// check user logged in

function ulog_insert_user_login_details_to_db(){

if(is_user_logged_in()){
	$current_user = wp_get_current_user();
	$tuname=$current_user->user_login;
	$tuid=$current_user->ID;
	global $wp_roles;
	$turoles = $current_user->roles[0];

  //check ip from share internet
  $turemote_addr = $_SERVER['REMOTE_ADDR'];

	global $wpdb;
	$table_name = $wpdb->prefix . "ulog_history";
  $wpdb->insert(
  	$table_name,
  	array(
  		'tuuser_name' => $tuname,
  		'tuuser_role' => $turoles,
  		'tuuser_ip_address' => $turemote_addr,
  		'tuuser_status' => "logged In",
  		'user_id' => $tuid,
  		'time' => current_time( 'mysql' )
  	));
}
}
add_action( 'init', 'ulog_insert_user_login_details_to_db');

// show all resutls
