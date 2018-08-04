/**
 * Show/hide Post Format meta boxes as needed
 */

jQuery(document).ready(function($) {

    // Post
    var quoteOptions    = $('#exort-metabox-quote');
    var quoteTrigger    = $('#post-format-quote');

    var videoOptions    = $('#exort-metabox-video');
    var videoTrigger    = $('#post-format-video');

    var audioOptions    = $('#exort-metabox-audio');
    var audioTrigger    = $('#post-format-audio');

    var galleryOptions  = $("#exort-metabox-post-gallery");
    var galleryTrigger  = $("#post-format-gallery");

    var postFormatGroup = $('#post-formats-select input');

    quoteOptions.hide();
    videoOptions.hide();
    audioOptions.hide();
    galleryOptions.hide();

    postFormatGroup.change(function() {
        quoteOptions.hide();
        videoOptions.hide();
        audioOptions.hide();
        galleryOptions.hide();
        if ($(this).val() == 'quote') {
            quoteOptions.show();
        } else if ($(this).val() == 'video') {
            videoOptions.show();
        } else if ($(this).val() == 'audio') {
            audioOptions.show();
        } else if ($(this).val() == 'gallery') {
            galleryOptions.show();
        }
    });
    if (quoteTrigger.is(':checked')) {
        quoteOptions.show();
    }
    if (videoTrigger.is(':checked')) {
        videoOptions.show();
    }
    if (audioTrigger.is(':checked')) {
        audioOptions.show();
    }
    if (galleryTrigger.is(':checked')) {
        galleryOptions.show();
    }

    // Page - portfolio settings
    var pageTemplateGroup = $('#page_template');

    var portfolioOptions = $('#exort-meta-box-portfolio-page');
    var portfolioTrigger = $('#page_template option[value="template-portfolio.php"]');

    if ( portfolioTrigger.is(':checked') ) {
        portfolioOptions.css('display', 'block');
    } else {
        portfolioOptions.css('display', 'none');
    }

    pageTemplateGroup.on("change", function() {
        if ( portfolioTrigger.is(':checked') ) {
            portfolioOptions.css('display', 'block');
        } else {
            portfolioOptions.css('display', 'none');
        }
    });


    // Portfolio - Portfolio Item Settings
    var portfolioVideoGroup = $("#exort-metabox-portfolio-video");
    var portfolioMediaTypeTrigger = $("[name='_exort_portfolio_item_media_type']");
    if (portfolioMediaTypeTrigger.length > 0) {

        if (portfolioMediaTypeTrigger.val() == 'video') {
            portfolioVideoGroup.show();
        } else {
            portfolioVideoGroup.hide();
        }

        if (portfolioMediaTypeTrigger.val() == 'gallery') {
            $("[for='_exort_portfolio_item_gallery_view_style']").closest(".rwmb-field").show();
            $("[for='_exort_portfolio_item_gallery_image_size']").closest(".rwmb-field").show();
            galleryOptions.show();
        } else {
            $("[for='_exort_portfolio_item_gallery_view_style']").closest(".rwmb-field").hide();
            $("[for='_exort_portfolio_item_gallery_image_size']").closest(".rwmb-field").hide();
            galleryOptions.hide();
        }
        if (portfolioMediaTypeTrigger.val() == 'gallery' &&
            $("[name='_exort_portfolio_item_gallery_view_style']").val().indexOf('gallery') === 0) {
            $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").show();
        } else {
            $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").hide();
        }
        portfolioMediaTypeTrigger.on("change", function() {
            if ($(this).val() == 'gallery') {
                $("[for='_exort_portfolio_item_gallery_view_style']").closest(".rwmb-field").show();
                if ($("[name='_exort_portfolio_item_gallery_view_style']").val().indexOf('gallery') === 0) {
                    $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").show();
                } else {
                    $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").hide();
                }
                galleryOptions.show();
                $("[for='_exort_portfolio_item_gallery_image_size']").closest(".rwmb-field").show();
            } else {
                $("[for='_exort_portfolio_item_gallery_view_style']").closest(".rwmb-field").hide();
                $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").hide();
                galleryOptions.hide();
                $("[for='_exort_portfolio_item_gallery_image_size']").closest(".rwmb-field").hide();
            }

            if ($(this).val() == 'video') {
                portfolioVideoGroup.show();
            } else {
                portfolioVideoGroup.hide();
            }
        });
        $("[name='_exort_portfolio_item_gallery_view_style']").on("change", function() {
            if ($(this).val().indexOf('gallery') === 0) {
                $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").show();
            } else {
                $("[for='_exort_portfolio_item_gallery_columns']").closest(".rwmb-field").hide();
            }
        });
    }

});