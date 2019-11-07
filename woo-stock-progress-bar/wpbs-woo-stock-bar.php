<?php
/**
 * Plugin Name: woo stock count progress bar
 * Plugin URI: #
 * Description: This plugin will help you show woocommerce stock on single product page
 * Version: 1.0.0
 * Author: mehedi hasan
 * Author URI: http://yourdomain.com/
 * Developer: Your Name
 * Developer URI: http://yourdomain.com/
 * Text Domain: wpbsc
 * Domain Path: /languages
 *
 * Woo: 12345:342928dfsfhsf8429842374wdf4234sfd
 * WC requires at least: 2.2
 * WC tested up to: 2.3
 *
 * Copyright: © 2009-2015 WooCommerce.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


//add_action('woocommerce_before_add_to_cart_form','wpbs_current_stock');
function wpbs_total_sale(){
  if(is_product()){
      global $product;
      global $post;
      $stock = get_post_meta( $post->ID, '_stock', true );
      $wpbsSale=$product->get_total_sales();
      $wpbsTotalStock=intval($stock)+ intval($wpbsSale);
      echo '<div id="wpbs_total_sale" total-sale='.esc_attr( $wpbsSale ).' total-stock='.esc_attr($wpbsTotalStock).' ></div>';
  }
}
add_action('woocommerce_before_add_to_cart_form','wpbs_total_sale');



// enqueue scripts
function wpbs_scripts_register(){

  wp_enqueue_style( 'wpbs_custom_css', plugins_url('scripts/wpbs-style.css', __FILE__) );
  wp_enqueue_script( 'wpbs_jqmeter', plugins_url('scripts/jqmeter.min.js', __FILE__), array('jquery'),null,true);
  wp_enqueue_script( 'wpbs_custom_script', plugins_url('scripts/custom.js', __FILE__), array('jquery'),null,true);
  // wp_localize_script( 'wpbs_custom_script', 'wpbs_stock_ob', array(
  //       'currentStock'=>wpbs_current_stock(),
  //       'totalSale'=>wpbs_total_sale(),
  //       'totalStock'=>wpbs_total_stock(),
  //
  // ) );
}
add_action('wp_enqueue_scripts','wpbs_scripts_register');

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Put your plugin code here
    add_action( 'woocommerce_before_add_to_cart_form', 'wpbs_show_stock_shop', 10 );

    function wpbs_show_stock_shop() {
      if(is_product()){
        global $product;
        global $post;
        $stock = get_post_meta( $post->ID, '_stock', true );
        $wpbsSalec=$product->get_total_sales();
        $wpbsTotalStock=intval($stock)+ intval($wpbsSalec);
        ?>
        <div class="wpbs-stock-counter">
          <p class="stock-progressbar-status"><span class="total-sold"> <?php echo esc_html__("Sold: {$wpbsSalec}",'wpbsc'); ?></span><span class="instock"><?php echo  esc_html__("Stock: {$stock}",'wpbsc'); ?> </span></p>
          <div id="jqmeter-container"></div>

        </div>

      <?php
      }
    }
}
