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
    gueryNumb = "",
    queryParam = query,
    pages = '',
    id = 1;



$.post(infinity_URL, function (response) {
     
    var $result = $(response).find('.page-list');

    pages = parseInt($result.attr('data-custom-pagination'));
 
})

document.addEventListener('DOMContentLoaded', function (e) {
    // $(parentDOM).children().remove();

    prestashop.on("updateProductList", () => {
        if (parentElement) {
            infiniteScroll();
        }

        if (SCROLL_TYPE == 'button' && parentElement) {
            if (!parentElement) {
                $('.bon-scroll-button').removeClass('display');
            } else {
                $('.bon-scroll-button').addClass('display');
            }
            infiniteButton();
        }
    });

    if (SCROLL_TYPE == 'scroll' && parentElement) {
        infiniteScroll();
    }

    if (SCROLL_TYPE == 'button' && parentElement) {
        if (!parentElement) {
            $('.bon-scroll-button').removeClass('display');
        } else {
            $('.bon-scroll-button').addClass('display');
        }
        infiniteButton();
    }
});



function infiniteButton() {
    $('.bon-scroll-button').on('click', function (e) {
    
        gueryNumb = '?page='
     
        e.preventDefault();

        let urlByButton = infinity_URL + gueryNumb + parentElemenId;
 

        $.post(urlByButton, function (response) {
            var $result = $(response).find('article');
            $result.each(function (index, article) {
                $(article).removeClass('col-xl-4').addClass('col-xl-3');
                setTimeout(function () {
                
                    $(parentDOM).append(article);
                    $('.products .product').css('display', 'block');
                    let count8 = 1;
                    $('.js-product').each(function () {
                        $(this).attr('data-timeout', count8 * 60);
                        count8++;
                    });
                }, index * 100);
            });
  
            if (id > pages-1) {
                $('.bon-scroll-button').css('display', 'none')
            }
        })
        parentElemenId++
        $(this).attr('data-id', id++);
    });
}


function infiniteScroll() {

    if (SCROLL_TYPE == 'scroll') {
  
        gueryNumb = '?page='
        

        $(parentElement).attr('id', parentElemenId);

        $(window).scroll(function addScroll() {
            
            if ($(this).height() + $(this).scrollTop() >= parentElement.scrollHeight-100) {
                
                ajax();
                
                parentElemenId++
                $(parentElement).attr('id', parentElemenId);

                if (+($(parentElement).attr('id')) > +(pages)) {
                    $(window).off('scroll', addScroll);
                }
            } 
        });

        function ajax() {
            $.post(infinity_URL + gueryNumb + parentElemenId, function (response) {
                product_col = JSON.parse(localStorage.getItem("ProductCol")) || 3;
                var $result = $(response).find('article');
                $result.each(function (index, article) {
                    $(article).removeClass('col-xl-4').addClass('col-xl-3');
                    setTimeout(function () {
                        $(parentDOM).append(article);
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