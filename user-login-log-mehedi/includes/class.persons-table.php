<?php
if ( ! class_exists( "WP_List_Table" ) ) {
	require_once( ABSPATH . "wp-admin/includes/class-wp-list-table.php" );
}

class Ulog_Table extends WP_List_Table {


	function __construct( $data ) {
			parent::__construct();
			$this->items = $data;
		}


	function get_columns() {

		return [
			'cb'    => '<input type="checkbox">',
			'tuid'    => __( 'Id', 'ulogdata' ),
			'tuuser_name'  => __( 'User Name', 'ulogdata' ),
			'tuuser_role' =>__('User Role','ulogdata'),
			'tuuser_ip_address' => __( 'IP address', 'ulogdata' ),
			'tuuser_status'   => __( 'Status', 'ulogdata' ),
			'time'   => __( 'Date', 'ulogdata' ),
		];
	}

	function column_cb( $item ) {
		return "<input type='checkbox' value='{$item['tuid']}'/>";
	}

		function column_default( $item, $column_name ) {
			return $item[ $column_name ];
		}

	function prepare_items() {

		$this->_column_headers = array( $this->get_columns(), [],[] );


	}


}
