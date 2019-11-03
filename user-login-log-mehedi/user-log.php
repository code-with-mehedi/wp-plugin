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

/*
 * Insert record into wp_user_activity table
*/
if (!function_exists('ulog_insert_user_to_db')) {
    function ulog_insert_user_to_db($tuname,$tuid,$tuser_status,$user_role,$turemote_addr) {
			global $wpdb;
			$table_name = $wpdb->prefix . "ulog_history";
		  $wpdb->insert(
		  	$table_name,
		  	array(
		  		'tuuser_name' => $tuname,
		  		'tuuser_role' => $user_role,
		  		'tuuser_ip_address' => $turemote_addr,
		  		'tuuser_status' => $tuser_status,
		  		'user_id' => $tuid,
		  		'time' => current_time('mysql')
		  	));
    }

}

// add_action('init',function(){
// 	echo $tuid = get_current_user_id();
//
// });
if (!function_exists('ulog_shook_wp_login')):

    function ulog_shook_wp_login($user_login=null , $user) {
				global $wpdb;
        $tuser_status = "logged in";
				//$tuid = get_current_user_id();
				$tuid = $user->ID;
				$user = new WP_User($tuid);
				global $wp_roles;
				$role_name = array();
				if (!empty($user->roles) && is_array($user->roles)) {
						foreach ($user->roles as $user_r) {
								$role_name[] = $wp_roles->role_names[$user_r];
						}
						$user_role = implode(', ', $role_name);
				}

				$turemote_addr = $_SERVER['REMOTE_ADDR'];
				$tuname=$user->display_name;


        ulog_insert_user_to_db($tuname,$tuid,$tuser_status,$user_role,$turemote_addr);

    }

endif;
add_action('wp_login', 'ulog_shook_wp_login',20,2);
// update status after user logged out
add_action('wp_logout', 'ulog_shook_wp_logout');
if (!function_exists('ulog_shook_wp_logout')):

    function ulog_shook_wp_logout() {
				global $wpdb;
        $tuser_status = "logged out";
				//$tuid = get_current_user_id();
				$tuid = get_current_user_id();
				$user = new WP_User($tuid);
				global $wp_roles;
				$role_name = array();
				if (!empty($user->roles) && is_array($user->roles)) {
						foreach ($user->roles as $user_r) {
								$role_name[] = $wp_roles->role_names[$user_r];
						}
						$user_role = implode(', ', $role_name);
				}

				$turemote_addr = $_SERVER['REMOTE_ADDR'];
				$tuname=$user->display_name;


        ulog_insert_user_to_db($tuname,$tuid,$tuser_status,$user_role,$turemote_addr);

    }

endif;
