window.TSReviewsOverview = (function () {

    var ajaxObj = ts_reviews_ajax_object;
    var host;
    var email;
    var siteId;
    var $ = jQuery;
    var endpointHost = "https://www.trustedsite.com"
    var cdnHost = "https://cdn.trustedsite.com"

    var refreshInterval;    

    function refresh(){
        // Usage of cdn is required
        var apiUrl =  cdnHost + "/rpc/ajax?do=lookup-site&host=" + encodeURIComponent(host);
        var woocommerce = parseInt($("#ts-data").attr("data-woocommerce"));
        jQuery.getJSON(apiUrl,function(data) {
            console.log(data);
            var success = data['success'];
            if(success === 0){
                showActivation();
            }else{
                siteId = data['site_id'];
                $("#ts-data").attr("data-siteid", siteId);
                jQuery("#activation").hide();
                jQuery("#pitch").hide();

                if(woocommerce){
                    jQuery("#settings").show();
                }else{
                    jQuery("#pitch").show();
                }
                
                jQuery("#manage").show();

                setTimeout(function(){
                    clearInterval(refreshInterval);
                }, 500);
            }
        }).fail(function() {
            showActivation();
        });
    }

    function showActivation() {
        jQuery("#manage").hide();
        jQuery("#settings").hide();
        jQuery("#pitch").show();
        jQuery("#activation").show();
    }

    function init(){
        var $data = jQuery("#ts-data");
        host = $data.attr('data-host');
        if(!host){ host = '';}
        email = $data.attr('data-email');
        if(!email){ email = '';}

        var left = window.innerWidth / 2 - 250;
        var top = 200;

        jQuery("#create-account").click(function(){
            var host = $("#host").val();
            var email = $("#email").val();
            var signupUrl = endpointHost + "/app/partner/signup?ctx=popup&host=" + encodeURIComponent(host) + "&email=" + encodeURIComponent(email) + "&platformId=5&ctx=popup&affId=6";
            var signupWindow = window.open(signupUrl, "_blank", "width=900 height=700 left=" + left + " top=" + top);
        });


        jQuery("#manage-account").click(function(){
            var left = window.innerWidth / 2 - 250;
            window.open(endpointHost + "/user/site/?siteId="+ siteId, "_blank", "width=900 height=700 left=" + left + " top=" + top);
        });

        jQuery("#ts-product-reviews-gallery").change(updateSettings);
        jQuery("#ts-product-stars").change(updateSettings);

        refreshInterval = setInterval(refresh, 1000);
    }

    function updateSettings(){
        var postData = {
            action: 'ts_reviews_update_settings',
            ts_product_reviews_gallery_enabled: jQuery("#ts-product-reviews-gallery").is(":checked") ? 1 : 0,
            ts_product_stars_enabled: jQuery("#ts-product-stars").is(":checked") ? 1 : 0
        };  
        console.log(ajaxObj.ajax_url);
        console.log(postData);

        $.post(ajaxObj.ajax_url, postData, function (data) {
            console.log(data);
        });
    }

    return {
        init: init
    }
})();