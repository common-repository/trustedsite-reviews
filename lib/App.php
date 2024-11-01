<?php
namespace TSReviews;
if ( ! defined( 'ABSPATH' ) ) exit;

require_once('AdminApi.php');
class  App
{
    public static function activate()
    {
        update_option("ts_reviews_active", 1);
    }

    public static function install()
    {
        add_shortcode('trustedsite_widget', 'TSReviews\App::widgetShortcode');
        add_action('admin_menu', 'TSReviews\App::adminMenus');
        add_action('wp_footer', 'TSReviews\App::injectMainCode');
        add_action('admin_enqueue_scripts', 'TSReviews\App::scripts');        

        if (App::hasWoocommerce()) {
            add_action('wp_ajax_ts_reviews_update_settings', 'TSReviews\AdminApi::updateSettings');
            App::installWoocommerce();
        }
    }

    public static function hasWoocommerce(){
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')));
    }

    public static function postPurchaseReview($order_id)
    {
        $endpoint_host = "https://www.trustedsite.com";
        $order = new \WC_Order($order_id);
        $order_total = $order->get_total();
        $first_name = $order->billing_first_name;
        $last_name = $order->billing_last_name;
        $order_number = $order->get_order_number();
        $email = $order->billing_email;

        if (empty($email)) {
            return;
        }
        $country_code = $order->billing_country;

        $arrHost = parse_url(home_url('', $scheme = 'http'));
        $host = $arrHost['host'];
        $req_url = $endpoint_host . "/api/v1/track-site-conversion.json?t=purchase&s=6&o=" . urlencode($order_number) . "&e=" . urlencode($email) . "&fn=" . urlencode($first_name) . "&ln=" . urlencode($last_name) . "&c=" . urlencode($country_code) . "&h=" . urlencode($host);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $req_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        // error_log("Resp: ". $response);
        curl_close($curl);
    }

    public static function installWoocommerce()
    {
        add_action('woocommerce_thankyou', 'TSReviews\App::postPurchaseReview');    
        if(intval(get_option(AdminApi::PRODUCT_REVIEWS_GALLERY_ENABLED_OPT)) == 1){
            add_action('woocommerce_after_single_product', 'TSReviews\App::installProductReviewsGallery');
        }

        if(intval(get_option(AdminApi::PRODUCT_STARS_ENABLED_OPT)) == 1){
            add_action('woocommerce_single_product_summary', 'TSReviews\App::installProductPageStars');
        }
    }

    public static function deactivate()
    {
        delete_option("ts_reviews_active");
    }

    public static function uninstall()
    {
        
    }

    public static function installProductPageStars(){
        global $product;
        $id = $product->id;

        echo "<div class=\"trustedsite-widget\" data-type=\"7\" data-pid=\"".$id."\"></div>";
    }

    public static function installProductReviewsGallery()
    {
        global $product;
        $id = $product->id;
        echo "<div class=\"trustedsite-widget\" data-type=\"5\" data-pid=\"".$id."\" style=\"margin:auto; max-width: 1200px;\"></div><script src='".plugins_url('../widgets/product_review_gallery.js', __FILE__)."'></script>";
    }   

    public static function scripts($hook) {
        if (strpos($hook, "ts-reviews-overview") !== false) {
            wp_enqueue_script('ts-reviews-overview-script', plugins_url('../js/overview.js', __FILE__), array('jquery'));                                        
            $ts_reviews_ajax_object = array('ajax_url' => admin_url('admin-ajax.php'), 'data' => array());
            wp_localize_script('ts-reviews-overview-script', 'ts_reviews_ajax_object', $ts_reviews_ajax_object);
        }        
    }

    public static function adminMenus()
    {
        add_menu_page(
            'TrustedSite',
            'TrustedSite',
            'activate_plugins', 
            'ts-reviews-overview', 
            'TSReviews\App::menuOverview',
            plugins_url('../images/trustedsite-app-icon.png', __FILE__)
            );
    }

    public static function menuOverview()
    {
        require WP_PLUGIN_DIR . '/trustedsite-reviews/views/overview.php';
    }

    public static function widgetShortcode($atts = array())
    {
        $a = shortcode_atts(array('type' => 'button', 'pid' => ''), $atts);
        $type = $a['type'];
        $pid = $a['pid'];
        
        $map = array(
            "button" => 2,
            "carousel" => 4,
            "gallery" => 5,
            "summary" => 8,
            "stars" => 7
        );

        $tid = 2;
        if(array_key_exists($type, $map)){
            $tid = $map[$type];
        }
        
        return "<div class='trustedsite-widget' data-type='" . $tid . "' data-pid='" . $pid . "'></div>";
    }

    public static function injectMainCode()
    {
       echo <<<EOT
           <script type="text/javascript" async src="//cdn.trustedsite.com/js/1.js"></script>
EOT;
    }
}

?>