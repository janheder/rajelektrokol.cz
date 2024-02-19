/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Rollover Image
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*/


$(window).load(function() {
    rollover();
    rollover_1_7();
    window.onresize = function (){
        rollover();
        rollover_1_7();
    }
});


function rollover_1_7() {
    $(document).on('mouseenter', '.thumbnail-container-images', function () {
        var count_img = $(this).find('.product-thumbnail img').size();
        if (count_img > 1) {
            if (ROLLOVER_ITEM_TYPE == 'opacity') {
                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().animate({opacity: 0});
                $(this).find('.product-thumbnail').find('.act-image').stop().animate({opacity: 1});
            } else if (ROLLOVER_ITEM_TYPE == 'hr_hover') {

                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().css('left', 0).animate({left: '-100%'});
                $(this).find('.product-thumbnail').find('.act-image').stop().css({left: '100%', opacity: 1}).animate({left: 0});
            } else if (ROLLOVER_ITEM_TYPE == 'vr_hover') {
                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().css('top', 0).animate({top: '100%'});
                $(this).find('.product-thumbnail').find('.act-image').stop().css({top: '-100%', opacity: 1}).animate({top: 0});
            }
        }
    });
    $(document).on('mouseleave', '.thumbnail-container-images', function () {
        var count_img = $(this).find('.product-thumbnail img').size();
        if (count_img > 1) {
            if (ROLLOVER_ITEM_TYPE == 'opacity') {
                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().animate({opacity: 1});
                $(this).find('.product-thumbnail').find('.act-image').stop().animate({opacity: 0});
            } else if (ROLLOVER_ITEM_TYPE == 'hr_hover') {
                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().animate({left: '0'});
                $(this).find('.product-thumbnail').find('.act-image').stop().animate({left: '100%'});
            } else if (ROLLOVER_ITEM_TYPE == 'vr_hover') {
                $(this).find('.product-thumbnail').find('img:not(.act-image)').stop().animate({top: '0'});
                $(this).find('.product-thumbnail').find('.act-image').stop().animate({top: '-100%'});
            }
        }
    });
}

function rollover() {
    $(document).on('mouseenter', '.product-image-container', function () {
        var count_img = $(this).find('.product_img_link img').size();
        if (count_img > 1) {
            if (ROLLOVER_ITEM_TYPE == 'opacity') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().animate({opacity: 0});
                $(this).find('.product_img_link').find('.act-image').stop().animate({opacity: 1});
            } else if (ROLLOVER_ITEM_TYPE == 'hr_hover') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().css('left', 0).animate({left: '-100%'});
                $(this).find('.product_img_link').find('.act-image').stop().css({left: '100%', opacity: 1}).animate({left: 0});
            } else if (ROLLOVER_ITEM_TYPE == 'vr_hover') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().animate({top: '200px'});
                $(this).find('.product_img_link').find('.act-image').stop().css({top: '-100%', opacity: 1}).animate({top: 0});
            }
        }
    });
    $(document).on('mouseleave', '.product-image-container', function () {
        var count_img = $(this).find('.product_img_link img').size();
        if (count_img > 1) {
            if (ROLLOVER_ITEM_TYPE == 'opacity') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().animate({opacity: 1});
                $(this).find('.product_img_link').find('.act-image').stop().animate({opacity: 0});
            } else if (ROLLOVER_ITEM_TYPE == 'hr_hover') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().animate({left: 0});
                $(this).find('.product_img_link').find('.act-image').stop().animate({left: '100%'});
            } else if (ROLLOVER_ITEM_TYPE == 'vr_hover') {
                $(this).find('.product_img_link').find('img:not(.act-image)').stop().animate({top: 0});
                $(this).find('.product_img_link').find('.act-image').stop().animate({top: '-100%'});
            }
        }
    });
}