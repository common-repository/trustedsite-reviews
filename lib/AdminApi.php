<?php
namespace TSReviews;
if ( ! defined( 'ABSPATH' ) ) exit;

class AdminApi {

    const PRODUCT_REVIEWS_GALLERY_ENABLED_OPT = 'ts_product_reviews_gallery_enabled';
    const PRODUCT_STARS_ENABLED_OPT = 'ts_product_stars_enabled';

    public static function updateSettings() {        
        update_option(
            AdminApi::PRODUCT_REVIEWS_GALLERY_ENABLED_OPT, 
            intval($_POST[AdminApi::PRODUCT_REVIEWS_GALLERY_ENABLED_OPT])
        );
        update_option(
            AdminApi::PRODUCT_STARS_ENABLED_OPT, 
            intval($_POST[AdminApi::PRODUCT_STARS_ENABLED_OPT])
        );

        $stars_enabled = get_option(AdminApi::PRODUCT_STARS_ENABLED_OPT, 0);
        $gallery_enabled = get_option(AdminApi::PRODUCT_REVIEWS_GALLERY_ENABLED_OPT, 0);
        
        wp_send_json(array(
            AdminApi::PRODUCT_STARS_ENABLED_OPT => $stars_enabled,
            AdminApi::PRODUCT_REVIEWS_GALLERY_ENABLED_OPT => $gallery_enabled
        ));
    }    
}