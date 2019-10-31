<?php
function ulogdata_admin_page() {
	add_menu_page(
		__( 'User login History', 'ulogdata' ),
		__( 'User log', 'ulogdata' ),
		'manage_options',
		'datatable',
		'datatable_display_table'
	);
}


function datatable_display_table() {
	?>
    <div class="wrap">
        <h2><?php _e( "User Activity Log", "ulogdata" ); ?></h2>
			  <?php
				global $wpdb;
				$ulogview =$wpdb->get_results (" SELECT tuid,tuuser_name,tuuser_role,tuuser_ip_address,tuuser_status,user_id,time FROM  {$wpdb->prefix}ulog_history ",ARRAY_A);

				$table = new Ulog_Table($ulogview);
				$table->prepare_items();
				$table->display();
			 ?>
    </div>
	<?php

}

add_action( "admin_menu", "ulogdata_admin_page" );
