<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ------------------------------------------------------------------------------------------------------------------
 * @package trustedsite-reviews
 * @version 1.0.15
 * Plugin Name: TrustedSite Reviews
 * Description: Add TrustedSite Reviews to your site and start showing visitors how great your business is.
 * Author: TrustedSite
 * Version: 1.0.15
 * Author URI: https://www.trustedsite.com/
 * ------------------------------------------------------------------------------------------------------------------
 */

if(defined('WP_INSTALLING') && WP_INSTALLING){
    return;
}
define('TS_REVIEWS', '1.0.15');

add_action('activated_plugin','ts_reviews_save_activation_error');
function ts_reviews_save_activation_error(){
    update_option('ts_reviews_plugin_error',  ob_get_contents());
}

require_once('lib/App.php');
register_activation_hook(__FILE__, 'TSReviews\App::activate');
register_deactivation_hook(__FILE__, 'TSReviews\App::deactivate');
register_uninstall_hook(__FILE__, 'TSReviews\App::uninstall');

TSReviews\App::install();

