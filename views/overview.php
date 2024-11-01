<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$email = get_option('admin_email');;
$arrHost = parse_url(home_url('', $scheme = 'http'));
$host = $arrHost['host'];
$woocommerce = in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ? 1 : 0;
$ts_product_reviews_gallery_enabled = intval(get_option('ts_product_reviews_gallery_enabled', 0));
$ts_product_stars_enabled = intval(get_option('ts_product_stars_enabled', 0));
?>
<div id="ts-data" data-host="<?php echo $host; ?>" data-email="<?php echo $email; ?>" data-woocommerce="<?php echo $woocommerce; ?>"></div>
<div class="wrap" id="overview">

    <h1>TrustedSite Reviews</h1>


    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="postbox-container-2" class="postbox-container">
                <div class="postbox">
                    <div class="meta-box-sortables" style="display:none;" id="pitch">
                        <h2 class="hndle"><span>About TrustedSite Reviews</span></h2>

                        <div class="inside">
                            <div id="ts-pitch">
                                <div class="left" style="width: 50%; float: left; display: inline-block; text-align: center;">
                                    <p>
                                        <a href="https://mcafeesecure.wistia.com/medias/qsfz19a4vo?wvideo=qsfz19a4vo" target="_blank"><img
                                                src="<?php echo plugins_url('../images/wistia-embed.jpg', __FILE__); ?>"
                                                width="400" height="225" style="width: 400px; height: 225px;"></a></p>
                                </div>
                                <div class="right"
                                     style="width: 49%; display: inline-block; margin-left: 10px; min-height: 260px;">
                                    <h4>Gain trust. Build your brand. Grow your business.</h4>

                                    <p>TrustedSite Reviews is the best way to show how great your business is. Collect and display unlimited reviews from real, verified customers—all at no cost.</p>

                                    <p>
                                    <ul>
                                        <li><span class="dashicons dashicons-yes"></span>Win the confidence of new customers by displaying positive reviews
                                        </li>
                                        <li><span class="dashicons dashicons-yes"></span>Collect unlimited reviews with the Reviews Button and postpurchase Reviews Email
                                        </li>
                                    </ul>
                                    </p>

                                    <div class="input-text-wrap">
                                        <input type="submit" class="button button-secondary" value="Learn More"
                                               onclick="openTs();">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="meta-box-sortables" style="display:none;" id="settings">
                        <h2 class="hndle"><span>Widget Settings</span></h2>

                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <th scope="row" class="titledesc" style="width: 20%; vertical-align: middle;">                                        
                                        <label >Product Reviews Gallery</label>
                                    </th>
                                    <td>
                                        <img src="<?php echo plugins_url('../images/mini-preview-reviews-widget-5.png', __FILE__); ?>" style="height: 70%"/>
                                    </td>
                                    <td>
                                        This feature requires TrustedSite Ecommerce Plan. To enable this widget on your product page, check this box and <a id="gallery-setting" target="_blank" style="cursor:pointer;">enable the Gallery widget on our dashboard.</a>
                                    </td>
                                    <td class="forminp forminp-checkbox">
                                        <label>
                                            <input type="checkbox" id="ts-product-reviews-gallery" value="1" <?php echo $ts_product_reviews_gallery_enabled == 1 ? "checked" : "" ?>>
                                            Enable
                                        </label>                                        
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row" class="titledesc" style="width: 20%; vertical-align: middle;">
                                        <label >Product Stars</label>
                                    </th>
                                    <td>
                                        <img src="<?php echo plugins_url('../images/mini-preview-reviews-widget-7.png', __FILE__); ?>" style="height: 70%"/>
                                    </td>
                                    <td>
                                        This feature requires TrustedSite Ecommerce Plan. To enable this widget on your product page, check this box and <a id="stars-setting" target="_blank" style="cursor:pointer;">enable the Product Stars widget on our dashboard.</a>
                                    </td>
                                    <td class="forminp forminp-checkbox">
                                        <label>
                                            <input type="checkbox" id="ts-product-stars" value="1" <?php echo $ts_product_stars_enabled == 1 ? "checked" : "" ?>>
                                            Enable
                                        </label>                                        
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="activation" style="display:none;">
                <div id="postbox-container-1" class="postbox-container">
                    <div class="postbox">
                        <div class="meta-box-sortables">
                            <h2 class="hndle"><span>Create Your Free Account</span></h2>

                            <div class="inside">
                                <div class="form-wrap">
                                    <div class="form-field form-required term-name-wrap" style="padding-top: 8px;">
                                        <label><strong>Email</strong></label>

                                        <div class="input-text-wrap">
                                            <input type="text" autocomplete="off" style="width: 100%" id="email"
                                                   value="<?php echo $email; ?>">
                                        </div>
                                    </div>

                                    <div class="form-field form-required term-name-wrap">
                                        <label><strong>Website</strong></label>

                                        <div class="input-text-wrap">
                                            <input type="text" autocomplete="off" style="width: 100%" id="host"
                                                   value="<?php echo $host; ?>">
                                        </div>
                                    </div>

                                    <div class="input-text-wrap" style="text-align: right;">
                                        <input type="submit" class="button button-primary" value="Create Account"
                                               style="margin-top: 8px; display: inline-block;" id="create-account">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="manage" style="display:none;">
                <div id="postbox-container-1" class="postbox-container">
                    <div class="postbox">
                        <div class="meta-box-sortables">
                            <h2 class="hndle"><span>Manage Account</span></h2>

                            <div class="inside">
                                <p>
                                    Manage your account at trustedsite.com
                                </p>
                                <div class="input-text-wrap">
                                    <input type="submit" class="button button-primary" value="Manage Account" style="margin-top: 8px; display: inline-block;" id="manage-account">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openTs(){
    window.open("https://trustedsite.com");
}
jQuery(function(){
    TSReviewsOverview.init();

    jQuery("#gallery-setting").click(function(e){
        var siteId = jQuery("#ts-data").attr("data-siteid");
        window.open("https://www.trustedsite.com/user/site/widget/?siteId="+siteId+"&type=5");
    })

    jQuery("#stars-setting").click(function(e){
        var siteId = jQuery("#ts-data").attr("data-siteid");
        window.open("https://www.trustedsite.com/user/site/widget/?siteId="+siteId+"&type=7");
    })
    
});


</script>