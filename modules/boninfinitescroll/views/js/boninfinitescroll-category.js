/*
 * 2015-2021 Bonpresta
 *
 * Infinite Scroll
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
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

let parentElement = document.querySelector('.products'),
    parentElemenId = 2,
    startUrl = window.location.href,
    gueryNumb = "",
    queryParam = query,
    blockpages = document.querySelector('.page-list'),
    pages = '',
    id = 2;

if (blockpages) {
    pages = parseInt($('.page-list').attr('data-custom-pagination'));
}

window.onload = function (e) {
    prestashop.on("updateProductList", () => {
        if (parentElement && blockpages) {
            infiniteScroll();
        }

        if (SCROLL_TYPE == 'button' && parentElement && blockpages) {
            if (!parentElement || !blockpages) {
                $('.bon-scroll-button').removeClass('display');
            } else {
                $('.bon-scroll-button').addClass('display');
            }
            infiniteButton();
        }
    });

    if (parentElement && blockpages) {
        infiniteScroll();
    }

    if (SCROLL_TYPE == 'button' && parentElement && blockpages) {
        if (!parentElement || !blockpages) {
            $('.bon-scroll-button').removeClass('display');
        } else {
            $('.bon-scroll-button').addClass('display');
        }
        infiniteButton();
    }
};

function infiniteScroll() {

    if (SCROLL_TYPE == 'scroll') {
        if (window.location.search) {
            gueryNumb = '&page='
        } else {
            gueryNumb = '?page='
        }

        $(parentElement).attr('id', parentElemenId);

        $(window).scroll(function addScroll() {
            if ($(this).height() + $(this).scrollTop() >= parentElement.scrollHeight) {

                ajax();

                parentElemenId++
                $(parentElement).attr('id', parentElemenId);
                $(window).off('scroll', addScroll);
                let parentElement2 = document.querySelector('.products');

                $(window).scroll(function addScrollNextPage() {

                    if ($(this).height() + $(this).scrollTop() >= parentElement2.scrollHeight) {
                        ajax();
                        $(window).off('scroll', addScrollNextPage);
                    }
                })
            }
        });

        function ajax() {
            $.post(window.location.href + gueryNumb + parentElemenId, function (response) {
                product_col = JSON.parse(localStorage.getItem("ProductCol")) || 3;
                var $result = $(response).find('article');
                $result.each(function (index, article) {

                    setTimeout(function () {
                        $('.products').append(article);
                        let count8 = 1;

                        $('#category .product-miniature').each(function () {
                            $(this).attr('data-timeout', count8 * 60);
                            count8++;
                        });
                    }, index * 100);
                });
            })
        }
    }
}

function infiniteButton() {
    $('.bon-scroll-button').on('click', function (e) {
        if (window.location.search) {
            gueryNumb = '&page='
        } else {
            gueryNumb = '?page='
        }
        e.preventDefault();
        $.post(window.location.href + gueryNumb + id, function (response) {
            var $result = $(response).find('article');
            $result.each(function (index, article) {
                setTimeout(function () {
                    $('#js-product-list .products').append(article);
                    let count8 = 1;
                    $('#category .product-miniature').each(function () {
                        $(this).attr('data-timeout', count8 * 60);
                        count8++;
                    });
                }, index * 100);
            });
            if (id > pages) {
                $('.bon-scroll-button').css('display', 'none')
                
            }
        })
        $(this).attr('data-id', id++);
    });
}