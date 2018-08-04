/*
 * Title:   Exort | Responsive Multi-Purpose WordPress Theme - Woocommerce Mini Cart JS
 * Author:  http://themeforest.net/user/soaptheme
 */

jQuery(function($) {

    // Woocommerce quantity button
    $(document).on("click", ".quantity .btn-minus", function(e) {
        var number;
        try {
            number = parseInt($(this).siblings(".qty").val(), 10);
        } catch (ex) { number = 1; }
        if (number >= 2) {
            $(this).siblings(".qty").val(number - 1);
            $("input[name=update_cart]").removeAttr("disabled");
        }
    });
    $(document).on("click", ".quantity .btn-plus", function(e) {
        var number;
        try {
            number = parseInt($(this).siblings(".qty").val(), 10);
        } catch (ex) { number = 1; }
        if ( number < 0 ) {
            number = 0;
        }
        $(this).siblings(".qty").val(number + 1);
        $("input[name=update_cart]").removeAttr("disabled");
    });

    // Woocommerce quick view
    $('body').on("click", ".product .button-quick-view", function(e) {
        var product_id = $(this).data('id'),
            data = { action: 'exort_ajax_product_quickview', productid: product_id },
            ajaxurl = exortLocal.ajaxurl,
            $this = $(this).closest('.product');
        data.nonce = exortLocal.ajaxNonce;
        if (ajaxurl == "" || ajaxurl == "#" || $this.hasClass("loading")) {
            return false;
        }
        $(".product.loading").removeClass("loading");
        $this.addClass('loading');
        $.post(ajaxurl, data, function(response) {
            if (response.success && $this.hasClass("loading")) {
                $.magnificPopup.open( {
                    mainClass: 'soap-quick-view-lightbox',
                    items: {
                        src: response.html,
                        type: 'inline'
                    },
                    callbacks: {
                        open: function() {
                            // Variation Form
                            var form_variation = $(".soap-quick-view-lightbox").find('form.variations_form');
                            if (form_variation.length > 0) {
                                form_variation.wc_variation_form();
                                form_variation.find("select option:selected").removeAttr("selected");
                            }
                            if ( $.fn.tooltip ) {
                                $(".soap-quick-view-lightbox").find("[data-toggle=tooltip]").tooltip();
                            }
                        },
                        change: function() {
                            
                        }
                    },
                    removalDelay: 300,
                });
            }
            $this.removeClass('loading');
        });
        e.preventDefault();
    });

    //$('body').bind('added_to_cart', exort_mini_cart_widget);

    $(".widget_product_categories .product-categories li.cat-parent").each(function() {
        $(this).click(function(e) {
            if ($(e.target).is($(this))) {
                e.preventDefault();
                var obj = this;
                $(this).children(".children").toggle(400, function() {
                    $(obj).toggleClass("current-cat-parent");
                });
            }
        });
    });

    $(document.body).on('updated_shipping_method updated_checkout', function() {
        $(".checkbox input[type='checkbox'], .radio input[type='radio']").each(function() {
            if ($(this).is(":checked")) {
                $(this).closest(".checkbox").addClass("checked");
                $(this).closest(".radio").addClass("checked");
            }
        });
    });
});

function exort_mini_cart_widget(event, parts, hash) {
    var miniCart = jQuery('.header-mini-cart');

    if ( parts['div.widget_shopping_cart_content'] ) {

        var $cartContent = jQuery(parts['div.widget_shopping_cart_content']),
            $itemsList = $cartContent .find('.cart_list'),
            $total = $cartContent .find('.total'),
            $buttons = miniCart.find('.buttons').clone();
        miniCart.find('.cart-content').html('');
        miniCart.find('.cart-content').append($itemsList, $total, $buttons);
    }
}