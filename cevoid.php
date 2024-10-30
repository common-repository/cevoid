<?php
/**
 * Plugin Name: Cevoid
 * Plugin URI: https://cevoid.com
 * Description: Cevoid plugin for woocommerce
 * Version: 1.0
 * Author: Cevoid AB
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'admin_menu', 'cevoid_plugin_menu' );


function cevoid_plugin_menu() {
  add_menu_page(
    __( 'Cevoid', 'textdomain' ),
    'Cevoid',
    'manage_options',
    'cevoid/options.php',
    '',
    plugins_url( 'cevoid/assets/menu_icon.png' )
);
}

function cevoid_scripts() {
  wp_enqueue_script('cevoid_default_script', 'https://gallery.cevoid.com/index.js', null, null, true);
}

function render_cevoid_script( $tag, $handle, $src ) {
  $defer = array( 
    'cevoid_default_script'
  );

  if ( in_array( $handle, $defer ) ) {
    return '<script src="' . $src . '" defer type="module"></script>' . "\n";
  }
    
  return $tag;
}

add_filter('script_loader_tag', 'render_cevoid_script', 10, 3 );
add_action('wp_head', 'cevoid_scripts');

function cevoid_widget_shortcode($atts) {
  global $product;

  if (is_null($product)) {
    return;
  }

  
  $atts = array_change_key_case((array)$atts, CASE_LOWER);
  $atts = shortcode_atts( array('type' => '', 'collection' => '', 'product' => '', 'tracking-id' => ''), $atts, 'Cevoid');

  if ($atts['product'] == 'auto') {
    $id = $product->get_id();
    return cevoid_widget_shortcode_callback($atts['type'], $atts['collection'], $id, $atts['tracking-id']);
  }

  
  return cevoid_widget_shortcode_callback($atts['type'], $atts['collection'], $atts['product'], $atts['tracking-id']);
}

function cevoid_widget_shortcode_callback($type, $collection, $product, $trackingId) {
  $widget = '<div id="cevoid-container"';

  if ($type) {
    $widget .= ' data-type="' . $type . '"';
  }

  if ($collection) {
    $widget .= 'data-campaign="' . $collection . '"';
  }

  if ($product) {
    $widget .= 'data-product="' . $product . '"';
  }

  if ($trackingId) {
    $widget .= 'data-tracking-id="' . $trackingId . '"';
  }

  return $widget .= '/>';
}

add_shortcode( 'Cevoid', 'cevoid_widget_shortcode' );

function cevoid_plugin_options() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}
?>