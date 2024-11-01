<?php
/*
Plugin Name: Zero to free text
Plugin URI: http://codeaffairs.com
Description: For woocommerce change product price 0 value to free text.
Version: 1.0
Author: Ugur CELIK
Author URI: info@codeaffairs.com
License: A "Slug" license name e.g. GPL2
*/

// Prevents direct file access
if(!defined('WPINC')){
    die();
}

function zero_to_free_text( $price, $product ) {
    if ( $product->get_price() == 0 ) {
        if ( $product->is_on_sale() && $product->get_regular_price() ) {
            $regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) );

            $price = wc_format_price_range( $regular_price, __( 'Free!', 'woocommerce' ) );
        } else {
            $price = '<span class="amount">' . __( 'Free!', 'woocommerce' ) . '</span>';
        }
    }

    return $price;
}

//Check if WooCommerce is active add filter.
if (in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )))) {
    add_filter( 'woocommerce_get_price_html', 'zero_to_free_text', 10, 2 );
}

