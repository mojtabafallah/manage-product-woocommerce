<?php
/**
* Plugin Name: Manage Product Woocomerce
* Plugin URI:  https://github.com/mojtabafallah13/manage-product-woocommerce
* Description: This plugin has been developed for managing WooCommerce products by the novin SEO team
* Version:     1.0.0
* Author:      MRW01F
* Author URI:  http://valendesigns.com
* Text Domain: manage-wc
*/
defined('ABSPATH') || exit();
include 'vendor/autoload.php';
include 'constants.php';
use app\init\init;
add_action('admin_menu',array(init::class, 'create_menu')) ;

function sunset_load_admin_scripts(){
    wp_enqueue_media();
    wp_register_script('sunset-admin-script',PLUGIN_URL .'/view/admin/js/myScript.js', array('jquery'), '1.0.0', true);
    wp_register_script('sunset-admin-script',PLUGIN_URL .'/view/admin/js/jquery.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('sunset-admin-script');
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );
