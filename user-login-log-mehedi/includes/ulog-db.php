<?php
// create table for this plugin

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
// $current_user = wp_get_current_user();
// $tuname=$current_user->user_login;
// $tuid=$current_user->ID;
// $turoles = $current_user->roles[0];
// return $roles;
// if(is_user_logged_in()){
//
//   $wpdb->insert(
//   	$table_name,
//   	array(
//   		'tuuser_name' => $tuname,
//   		'tuuser_role' => $turoles,
//   		'tuuser_ip_address' => 123,
//   		'tuuser_status' => 123,
//   		'user_id' => $tuid,
//   	),
//   	array(
//   		'%s',
//   		'%s',
//   		'%d',
//   		'%s',
//   		'%d'
//   	)
//   );
//
// }
